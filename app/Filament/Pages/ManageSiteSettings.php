<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use BackedEnum;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageSiteSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Ajustes del sitio';

    protected static ?string $modelLabel = 'ajustes del sitio';

    protected static ?string $title = 'Ajustes del sitio';

    protected static ?int $navigationSort = 100;

    protected string $view = 'filament.pages.manage-site-settings';

    /** @var array<string, mixed> */
    public array $data = [];

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('seo_title')
                    ->label('Título de la página (SEO)')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('seo_description')
                    ->label('Descripción (SEO)')
                    ->required()
                    ->rows(2)
                    ->maxLength(500)
                    ->columnSpanFull(),
                TextInput::make('hero_availability')
                    ->label('Disponibilidad (hero)')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('about_title')
                    ->label('Título del sobre mí')
                    ->hint('Puede usar <em> para resaltar')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('about_p1')
                    ->label('Sobre mí · párrafo 1')
                    ->required()
                    ->rows(2)
                    ->columnSpanFull(),
                Textarea::make('about_p2')
                    ->label('Sobre mí · párrafo 2')
                    ->required()
                    ->rows(2)
                    ->columnSpanFull(),
                Textarea::make('about_p3')
                    ->label('Sobre mí · párrafo 3')
                    ->required()
                    ->rows(2)
                    ->columnSpanFull(),
                TagsInput::make('taglines')
                    ->label('Taglines rotativos del hero')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('footer_made')
                    ->label('Texto del footer')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function mount(): void
    {
        $this->form->fill(app(SiteSettings::class)->toArray());
    }

    public function save(): void
    {
        $settings = app(SiteSettings::class);

        foreach ($this->form->getState() as $key => $value) {
            $settings->{$key} = $value;
        }

        $settings->save();

        Notification::make()
            ->title('Ajustes guardados')
            ->success()
            ->send();
    }
}
