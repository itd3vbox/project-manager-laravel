<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'image_info',
    ];

    public function getImageInfoAttribute()
    {
        if ($this->image) {
            $basePath = 'storage/' . $this->folder;
    
            return [
                'path' => asset($basePath . '/' . $this->image),
                'name' => $this->image,
            ];
        }
        return [
            'path' => 'https://assets.bigcartel.com/product_images/299586342/A8B52BAB-F334-4114-BA29-6A34A379A47F.jpeg?auto=format&amp;fit=max&amp;w=800',
            'name' => $this->image,
        ];
    }

}
