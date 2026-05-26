<?php

namespace App\Livewire;

use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        return view('livewire.home-page')
            ->layout('layouts.marketing', [
                'title' => 'PortfolioCV',
                'metaDescription' => 'PortfolioCV untuk mengelola data CV, publikasi SINTA, dan export PDF secara otomatis.',
            ]);
    }
}
