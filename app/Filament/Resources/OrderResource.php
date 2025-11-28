<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    // Ikon di menu samping (Truck)
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    
    // Label menu
    protected static ?string $navigationLabel = 'Kelola Pesanan';
    protected static ?string $modelLabel = 'Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pelanggan & Pengiriman')
                    ->description('Masukkan detail pesanan baru di sini.')
                    ->schema([
                        
                        // BARIS 1: Nama & WA
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('customer_name')
                                    ->label('Nama Pelanggan')
                                    ->required()
                                    ->placeholder('Misal: Budi Santoso'),

                                 Forms\Components\TextInput::make('item_name')
            ->label('Isi Paket / Nama Barang')
            ->placeholder('Contoh: Dokumen, Makanan, Baju')
            ->required()
            ->prefixIcon('heroicon-o-cube'),   
                                
                                Forms\Components\TextInput::make('whatsapp_number')
                                    ->label('Nomor WhatsApp')
                                    ->required()
                                    ->numeric()
                                    ->placeholder('Format: 628123456789')
                                    ->helperText('Gunakan awalan 62, jangan 0.'),
                            ]),

                        // BARIS 2: Ongkir & Jarak (FITUR BARU)
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('ongkir')
                                    ->label('Ongkos Kirim')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp'),

                                Forms\Components\TextInput::make('distance')
                                    ->label('Estimasi Jarak')
                                    ->required()
                                    ->numeric()
                                    ->suffix('km')
                                    ->helperText('Perkiraan jarak tempuh.'),
                            ]),

                        // BARIS 3: Lokasi
                        Forms\Components\Textarea::make('pickup_location')
                            ->label('Lokasi Jemput (Pasar/Toko)')
                            ->required()
                            ->rows(2)
                            ->placeholder('Nama Toko, Nama Pasar, Patokan...'),

                        Forms\Components\Textarea::make('dropoff_location')
                            ->label('Lokasi Antar (Rumah Pelanggan)')
                            ->required()
                            ->rows(2)
                            ->placeholder('Alamat lengkap penerima...'),

                        // BARIS 4: Catatan & Status
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Tambahan')
                            ->placeholder('Contoh: Titip beli gula 1kg, rumah pagar hitam...'),

                        Forms\Components\Select::make('status')
                            ->label('Status Pesanan')
                            ->options([
                                'pending' => 'Menunggu Kurir (Pending)',
                                'taken' => 'Sedang Diantar (Taken)',
                                'completed' => 'Selesai (Completed)',
                            ])
                            ->default('pending')
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Pelanggan
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->weight('bold'),

                // 2. Info Lokasi (Singkat)
                Tables\Columns\TextColumn::make('dropoff_location')
                    ->label('Tujuan')
                    ->limit(20)
                    ->tooltip(fn (Order $record): string => $record->dropoff_location),

                // 3. Jarak & Ongkir
                Tables\Columns\TextColumn::make('distance')
                    ->label('Jarak')
                    ->suffix(' km')
                    ->sortable(),

                Tables\Columns\TextColumn::make('ongkir')
                    ->label('Ongkir')
                    ->money('IDR')
                    ->sortable()
                    ->color('success'),

                // 4. Status (Badge Warna)
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',     // Abu-abu (Belum diambil)
                        'taken' => 'warning',    // Kuning (Sedang jalan)
                        'completed' => 'success',// Hijau (Selesai)
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'taken' => 'Diantar',
                        'completed' => 'Selesai',
                    }),

                // 5. Kurir (Siapa yang ambil)
                Tables\Columns\TextColumn::make('courier.name') // Relasi ke tabel users
                    ->label('Kurir')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')
                    ->label('Dibuat')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc') // Urutkan dari yang terbaru
            ->filters([
                // Filter status (Opsional, biar admin mudah cari)
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu',
                        'taken' => 'Sedang Jalan',
                        'completed' => 'Selesai',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}