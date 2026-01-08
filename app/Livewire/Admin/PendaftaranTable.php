<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pendaftaran;

class PendaftaranTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDir = 'desc';
    public $perPage = 10;

    protected $queryString = ['search', 'sortBy', 'sortDir'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }

    public function render()
    {
        $pendaftaran = Pendaftaran::with('user', 'fakultas', 'programStudi')
            ->where(function ($query) {
                $query->where('nama_lengkap', 'like', "%{$this->search}%")
                    ->orWhere('nik', 'like', "%{$this->search}%")
                    ->orWhereHas('user', function ($q) {
                        $q->where('email', 'like', "%{$this->search}%");
                    });
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.admin.pendaftaran-table', compact('pendaftaran'));
    }
}
