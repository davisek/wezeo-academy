<?php
namespace AppSlack\Slack\Http\Controllers;

use AppSlack\Slack\Models\Emoji;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class EmojiController extends Controller
{
    public function index()
    {
        return Emoji::all();
    }
}

