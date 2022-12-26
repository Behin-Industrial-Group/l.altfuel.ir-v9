<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedIssueModel extends Model
{
    use HasFactory;
    protected $table = 'related_issue';
    protected $fillable = [
        'issue_id', 'related_issue_id'
    ];
}
