<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Routing\Route;

use Illuminate\Support\ServiceProvider;
use App\Models\Layanan;

class MenuServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
        $verticalMenuData = json_decode($verticalMenuJson);
        $horizontalMenuJson = file_get_contents(base_path('resources/menu/horizontalMenu.json'));
        $horizontalMenuData = json_decode($horizontalMenuJson);

        $verticalMenuData->menu = $this->injectLayananMenu($verticalMenuData->menu);

        $this->app->make('view')->share('menuData', [$verticalMenuData, $horizontalMenuData]);
    }

    private function injectLayananMenu(array $menu): array
    {
        $headerIndex = null;
        foreach ($menu as $i => $item) {
            if (isset($item->menuHeader) && $item->menuHeader === 'LAYANAN') {
                $headerIndex = $i;
                break;
            }
        }

        if ($headerIndex === null) {
            return $menu;
        }

        $activeLayanan = Layanan::where('is_active', true)->get();

        $layananItems = [];
        foreach ($activeLayanan as $l) {
            $layananItems[] = (object) [
                'url' => $this->getLayananUrl($l),
                'icon' => $this->getLayananIcon($l->nama_layanan),
                'name' => $l->nama_layanan,
            ];
        }

        array_splice($menu, $headerIndex + 1, 0, $layananItems);

        return $menu;
    }

    private function getLayananUrl($l): string
    {
        return '/admin/ptsp?layanan_id=' . $l->id;
    }

    private function getLayananIcon(string $name): string
    {
        $name = strtolower($name);
        if (str_contains($name, 'buku tamu')) return 'menu-icon icon-base ti tabler-book';
        if (str_contains($name, 'ijazah')) return 'menu-icon icon-base ti tabler-download';
        if (str_contains($name, 'surat')) return 'menu-icon icon-base ti tabler-file-text';
        if (str_contains($name, 'legalisir')) return 'menu-icon icon-base ti tabler-certificate';
        return 'menu-icon icon-base ti tabler-building-community';
    }
}
