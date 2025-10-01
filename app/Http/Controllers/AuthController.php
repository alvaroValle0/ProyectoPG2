<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->withInput();
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'usuario', // Rol por defecto para usuarios registrados
            'activo' => true, // Usuario activo por defecto
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function perfil()
    {
        $usuario = auth()->user();
        return view('auth.perfil', compact('usuario'));
    }

    public function testAvatar()
    {
        // Método de prueba para verificar la funcionalidad
        $usuario = auth()->user();
        return response()->json([
            'usuario_id' => $usuario->id,
            'avatar_actual' => $usuario->avatar,
            'storage_path' => storage_path('app/public/avatars'),
            'public_path' => public_path('storage/avatars'),
            'storage_exists' => \Storage::disk('public')->exists('avatars'),
        ]);
    }

    public function actualizarAvatar(Request $request)
    {
        // Log para depuración
        \Log::info('Iniciando actualización de avatar', [
            'user_id' => auth()->id(),
            'has_file' => $request->hasFile('avatar'),
            'file_size' => $request->hasFile('avatar') ? $request->file('avatar')->getSize() : null,
        ]);

        // Verificar que el usuario esté autenticado
        if (!auth()->check()) {
            \Log::error('Usuario no autenticado al intentar actualizar avatar');
            return redirect()->back()->with('error', 'Debes estar autenticado para realizar esta acción.');
        }

        // Validación más simple
        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'avatar.required' => 'Debes seleccionar una imagen.',
                'avatar.image' => 'El archivo debe ser una imagen.',
                'avatar.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif.',
                'avatar.max' => 'La imagen no puede ser mayor a 2MB.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Error de validación en avatar', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->with('error', 'Error de validación: ' . implode(', ', $e->errors()['avatar'] ?? []));
        }

        try {
            $usuario = auth()->user();
            $archivo = $request->file('avatar');

            \Log::info('Archivo recibido', [
                'original_name' => $archivo->getClientOriginalName(),
                'size' => $archivo->getSize(),
                'mime_type' => $archivo->getMimeType(),
            ]);

            // Eliminar avatar anterior si existe
            if ($usuario->avatar && \Storage::disk('public')->exists('avatars/' . $usuario->avatar)) {
                \Storage::disk('public')->delete('avatars/' . $usuario->avatar);
                \Log::info('Avatar anterior eliminado', ['file' => $usuario->avatar]);
            }

            // Generar nombre único para el archivo
            $extension = $archivo->getClientOriginalExtension();
            $nombreArchivo = 'avatar_' . $usuario->id . '_' . time() . '.' . $extension;
            
            // Subir el archivo usando move_uploaded_file para mayor compatibilidad
            $destinationPath = storage_path('app/public/avatars');
            
            // Verificar que el directorio existe
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $archivo->move($destinationPath, $nombreArchivo);

            \Log::info('Archivo subido exitosamente', [
                'destination' => $destinationPath,
                'filename' => $nombreArchivo,
            ]);

            // Actualizar en la base de datos
            $usuario->avatar = $nombreArchivo;
            $usuario->save();

            \Log::info('Avatar actualizado en base de datos', ['avatar' => $nombreArchivo]);

            return redirect()->back()->with('success', 'Foto de perfil actualizada correctamente.');

        } catch (\Exception $e) {
            // Log del error para depuración
            \Log::error('Error al actualizar avatar: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);
            
            return redirect()->back()->with('error', 'Error al actualizar la foto de perfil: ' . $e->getMessage());
        }
    }

    public function eliminarAvatar()
    {
        try {
            $usuario = auth()->user();
            
            // Eliminar archivo del storage
            if ($usuario->avatar && \Storage::disk('public')->exists('avatars/' . $usuario->avatar)) {
                \Storage::disk('public')->delete('avatars/' . $usuario->avatar);
            }

            // Actualizar en la base de datos
            $usuario->update(['avatar' => null]);

            return redirect()->back()->with('success', 'Foto de perfil eliminada correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la foto de perfil. Inténtalo de nuevo.');
        }
    }

    public function actualizarPerfil(Request $request)
    {
        $usuario = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $usuario->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
        ], [
            'name.required' => 'El nombre completo es requerido.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'username.unique' => 'Este nombre de usuario ya está en uso.',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'direccion.max' => 'La dirección no puede tener más de 500 caracteres.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Log de los datos recibidos para debug
            \Log::info('Actualizando perfil para usuario: ' . $usuario->id, [
                'name' => $request->name,
                'username' => $request->username,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
            ]);

            // Actualizar información del usuario (sin email ya que es de solo lectura)
            $updated = $usuario->update([
                'name' => $request->name,
                'username' => $request->username ?: null,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
            ]);

            if ($updated) {
                \Log::info('Perfil actualizado exitosamente para usuario: ' . $usuario->id);
                return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
            } else {
                \Log::warning('No se pudo actualizar el perfil para usuario: ' . $usuario->id);
                return redirect()->back()
                    ->with('error', 'No se pudieron guardar los cambios. Inténtalo de nuevo.')
                    ->withInput();
            }

        } catch (\Exception $e) {
            \Log::error('Error al actualizar perfil para usuario: ' . $usuario->id, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al actualizar el perfil: ' . $e->getMessage())
                ->withInput();
        }
    }
} 