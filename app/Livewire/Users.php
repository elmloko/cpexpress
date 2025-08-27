<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $newPassword;
    public $userId;

    // Buscar usuarios
    public function searchUsers()
    {
        // Esto fuerza el refresco del render con el filtro
    }

    // Dar de baja (soft delete)
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('success', 'Usuario dado de baja correctamente.');
    }

    // Restaurar usuario
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        session()->flash('success', 'Usuario restaurado correctamente.');
    }

    // Abrir modal de cambio de contraseña
    public function setPasswordUser($id)
    {
        $this->userId = $id;
        $this->dispatch('openModal');
    }

    // Actualizar contraseña
    public function updatePassword()
    {
        $user = User::findOrFail($this->userId);
        $user->password = bcrypt($this->newPassword);
        $user->save();

        $this->dispatch('closeModal');
        session()->flash('success', 'Contraseña actualizada correctamente.');
    }

    public function render()
    {
        $users = User::withTrashed()
            ->where('name', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%")
            ->paginate(10);

        return view('livewire.users', compact('users'));
    }
}
