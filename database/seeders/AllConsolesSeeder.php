<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AllConsolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consoles = [
            ['name' => 'Magnavox Odyssey', 'picture' => 'magnavox_odyssey.jpg'],
            ['name' => 'Atari 2600', 'picture' => 'atari_2600.png'],
            ['name' => 'Atari 5200', 'picture' => 'atari_5200.png'],
            ['name' => 'Atari 7800', 'picture' => 'atari_7800.png'],
            ['name' => 'Intellivision', 'picture' => 'intellivision.png'],
            ['name' => 'ColecoVision', 'picture' => 'colecovision.png'],
            ['name' => 'Nintendo Entertainment System', 'picture' => 'nes.png'],
            ['name' => 'Sega Master System', 'picture' => 'sega_master_system.png'],
            ['name' => 'Atari Jaguar', 'picture' => 'atari_jaguar.png'],
            ['name' => 'TurboGrafx-16', 'picture' => 'turbografx_16.png'],
            ['name' => 'Super Nintendo Entertainment System', 'picture' => 'snes.png'],
            ['name' => 'Sega Genesis', 'picture' => 'sega_genesis.png'],
            ['name' => 'Neo Geo', 'picture' => 'neo_geo.png'],
            ['name' => '3DO Interactive Multiplayer', 'picture' => '3do.png'],
            ['name' => 'Sega Saturn', 'picture' => 'sega_saturn.png'],
            ['name' => 'Sony PlayStation', 'picture' => 'playstation.png'],
            ['name' => 'Nintendo 64', 'picture' => 'nintendo_64.png'],
            ['name' => 'Sega Dreamcast', 'picture' => 'sega_dreamcast.png'],
            ['name' => 'PlayStation 2', 'picture' => 'ps2.png'],
            ['name' => 'Nintendo GameCube', 'picture' => 'gamecube.png'],
            ['name' => 'Xbox', 'picture' => 'xbox.png'],
            ['name' => 'PlayStation Portable', 'picture' => 'psp.png'],
            ['name' => 'Nintendo DS', 'picture' => 'nds.png'],
            ['name' => 'PlayStation 3', 'picture' => 'ps3.png'],
            ['name' => 'Xbox 360', 'picture' => 'xbox_360.png'],
            ['name' => 'Nintendo Wii', 'picture' => 'wii.png'],
            ['name' => 'PlayStation Vita', 'picture' => 'ps_vita.png'],
            ['name' => 'Nintendo 3DS', 'picture' => '3ds.png'],
            ['name' => 'Wii U', 'picture' => 'wii_u.png'],
            ['name' => 'PlayStation 4', 'picture' => 'ps4.png'],
            ['name' => 'Xbox One', 'picture' => 'xbox_one.png'],
            ['name' => 'Nintendo Switch', 'picture' => 'nintendo_switch.png'],
            ['name' => 'PlayStation 5', 'picture' => 'ps5.png'],
            ['name' => 'Xbox Series X', 'picture' => 'xbox_series_x.png'],
            ['name' => 'Xbox Series S', 'picture' => 'xbox_series_s.png'],
            // Portáteis clássicos
            ['name' => 'Game Boy', 'picture' => 'gameboy.png'],
            ['name' => 'Game Boy Color', 'picture' => 'gameboy_color.png'],
            ['name' => 'Game Boy Advance', 'picture' => 'gameboy_advance.png'],
            ['name' => 'Neo Geo Pocket', 'picture' => 'neo_geo_pocket.png'],
            ['name' => 'WonderSwan', 'picture' => 'wonderswan.png'],
            ['name' => 'Atari Lynx', 'picture' => 'atari_lynx.png'],
            ['name' => 'Sega Game Gear', 'picture' => 'sega_game_gear.png'],
            // Outros
            ['name' => 'Ouya', 'picture' => 'ouya.png'],
            ['name' => 'Steam Deck', 'picture' => 'steam_deck.png'],
            ['name' => 'Playdate', 'picture' => 'playdate.png'],
            ['name' => 'Analogue Pocket', 'picture' => 'analogue_pocket.png'],
        ];

        foreach ($consoles as $console) {
            \App\Models\AllConsole::create($console);
        }
    }
}
