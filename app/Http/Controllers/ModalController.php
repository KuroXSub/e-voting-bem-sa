<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModalController extends Controller
{
    public function status(Request $request)
    {
        $title = $request->query('title');
        $message = $request->query('message');
        
        $iconColor = $this->getModalIconColor($title);
        $iconPath = $this->getModalIconPath($title);
        
        return view('components.modal-status', [
            'title' => $title,
            'message' => $message,
            'iconColor' => $iconColor,
            'iconPath' => $iconPath
        ]);
    }
    
    private function getModalIconColor($title)
    {
        if (strpos($title, 'Tidak Ada') !== false) return 'bg-gray-100 text-gray-500';
        if (strpos($title, 'Belum') !== false) return 'bg-blue-100 text-blue-500';
        if (strpos($title, 'Selesai') !== false) return 'bg-green-100 text-green-500';
        return 'bg-yellow-100 text-yellow-500';
    }
    
    private function getModalIconPath($title)
    {
        if (strpos($title, 'Sudah') !== false) return 'M5 13l4 4L19 7';
        return 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
    }
}