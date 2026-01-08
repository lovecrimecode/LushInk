<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingProgress extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'book_id',
        'current_page',
        'total_pages',
        'percentage_completed',
    ];

    public function search(Request $request)
    {
        $q = (string) $request->query('q', '');
        return response()->json($this->api->search($q));
    }

    public function details(string $id)
    {
        return response()->json($this->api->details($id));
    }

}
