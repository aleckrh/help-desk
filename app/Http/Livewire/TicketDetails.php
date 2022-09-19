<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use Filament\Notifications\Notification;
use Livewire\Component;

class TicketDetails extends Component
{
    public Ticket $ticket;
    public $menu;
    public $activeMenu;

    protected $listeners = ['ticketSaved'];

    public function mount(): void
    {
        $this->menu = [
            'Comments',
            'Activities',
        ];
        $this->activeMenu = $this->menu[0];
    }

    public function render()
    {
        return view('livewire.ticket-details');
    }

    /**
     * Change a menu (tab)
     *
     * @param $item
     * @return void
     */
    public function selectMenu($item)
    {
        $this->activeMenu = $item;
    }

    /**
     * Event launched after the ticket is updated
     *
     * @return void
     */
    public function ticketSaved(): void
    {
        $this->ticket = $this->ticket->refresh();
    }

    /**
     * Copy a ticket url
     *
     * @param Ticket $ticket
     * @return void
     */
    public function copyTicketUrl(Ticket $ticket): void {
        Notification::make()
            ->success()
            ->title(__('Ticket url copied'))
            ->body(__('The ticket url successfully copied to your clipboard'))
            ->send();
        $this->dispatchBrowserEvent('ticketUrlCopied', [
            'url' => route('tickets.number', [
                'number' => $ticket->ticket_number
            ])
        ]);
    }
}
