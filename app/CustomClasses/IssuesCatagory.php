<?php 

namespace App\CustomClasses;

class IssuesCatagory
{
    public static function Catagory_fa2en($text)
    {
        switch($text):
            case 'پذیرش اولیه':
                $level = "recept";
                break;
            case "واحد آموزش":
                $level = "education";
                break;
            case "واحد بازرسی":
                $level = "inspection";
                break;
            case "واحد مالی":
                $level = "financial";
                break;
            case "irngv":
                $level = "irngv";
                break;
            case "IrngvRegPiece":
                $level = "IrngvRegPiece";
                break;
            default:
                $level = "irngv";
                break;
        endswitch;
        
        return $level;
    }
    
    public static function Catagory_en2fa($text)
    {
        switch($text):
            case 'recept':
                $level = "پذیرش اولیه";
                break;
            case "education":
                $level = "واحد آموزش";
                break;
            case "inspection":
                $level = "واحد بازرسی";
                break;
            case "financial":
                $level = "واحد مالی";
                break;
            case "irngv":
                $level = "irngv";
                break;
            case "IrngvRegPiece":
                $level = "IrngvRegPiece";
                break;
            default:
                $level = "irngv";
                break;
        endswitch;
        
        return $level;
    }
}