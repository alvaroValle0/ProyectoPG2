<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketHistory extends Model
{
    use HasFactory;

    protected $table = 'ticket_histories';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'action',
        'old_data',
        'new_data',
        'description',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
        'created_at' => 'datetime'
    ];

    // Relaciones
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByTicket($query, int $ticketId)
    {
        return $query->where('ticket_id', $ticketId);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Accessors
    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'created' => 'Creado',
            'updated' => 'Actualizado',
            'status_changed' => 'Estado Cambiado',
            'signed' => 'Firmado',
            'delivered' => 'Entregado',
            'cancelled' => 'Cancelado',
            'printed' => 'Impreso',
            default => 'Acción Desconocida'
        };
    }

    public function getActionIconAttribute(): string
    {
        return match($this->action) {
            'created' => 'fas fa-plus-circle',
            'updated' => 'fas fa-edit',
            'status_changed' => 'fas fa-exchange-alt',
            'signed' => 'fas fa-signature',
            'delivered' => 'fas fa-check-circle',
            'cancelled' => 'fas fa-times-circle',
            'printed' => 'fas fa-print',
            default => 'fas fa-question-circle'
        };
    }

    public function getActionColorAttribute(): string
    {
        return match($this->action) {
            'created' => 'success',
            'updated' => 'primary',
            'status_changed' => 'warning',
            'signed' => 'info',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'printed' => 'secondary',
            default => 'secondary'
        };
    }

    // Métodos estáticos para registrar historial
    public static function recordCreated(Ticket $ticket, User $user, array $data = []): self
    {
        return static::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'action' => 'created',
            'new_data' => $data,
            'description' => "Ticket {$ticket->numero_ticket} creado",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public static function recordUpdated(Ticket $ticket, User $user, array $oldData, array $newData, string $description = null): self
    {
        return static::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'action' => 'updated',
            'old_data' => $oldData,
            'new_data' => $newData,
            'description' => $description ?? "Ticket {$ticket->numero_ticket} actualizado",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public static function recordStatusChanged(Ticket $ticket, User $user, string $oldStatus, string $newStatus): self
    {
        return static::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'action' => 'status_changed',
            'old_data' => ['estado' => $oldStatus],
            'new_data' => ['estado' => $newStatus],
            'description' => "Estado del ticket {$ticket->numero_ticket} cambiado de '{$oldStatus}' a '{$newStatus}'",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public static function recordSigned(Ticket $ticket, User $user, array $signatureData = []): self
    {
        return static::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'action' => 'signed',
            'new_data' => $signatureData,
            'description' => "Ticket {$ticket->numero_ticket} firmado",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public static function recordDelivered(Ticket $ticket, User $user): self
    {
        return static::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'action' => 'delivered',
            'description' => "Ticket {$ticket->numero_ticket} marcado como entregado",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public static function recordCancelled(Ticket $ticket, User $user, string $reason = null): self
    {
        return static::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'action' => 'cancelled',
            'new_data' => ['reason' => $reason],
            'description' => "Ticket {$ticket->numero_ticket} cancelado" . ($reason ? ": {$reason}" : ""),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public static function recordPrinted(Ticket $ticket, User $user): self
    {
        return static::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'action' => 'printed',
            'description' => "Ticket {$ticket->numero_ticket} impreso",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }
}
