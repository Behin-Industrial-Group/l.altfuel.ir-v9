<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\RequestTrait;

class TelegramController extends Controller
{
    use RequestTrait;
    
    private $home = [
        'mainPage' => [
            'name' => 'صفحه اصلی',
            ],
        'joined' => [
            'name' => 'عضو شدم',
            'url' => 'https://t.me/special_sell',
            ],
        'manualSearch'=> [
            'name' => 'جستجوی دستی',
            ],
        ];
    
    private $buttons = [
        'electronic-devices' => [
            'name' => 'کالای دیجیتال',
            'method' => '',
            'sub_catagory' => [
                '0' => [ 
                    'name' => 'لوازم جانبی گوشی',
                    'url' => 'search/category-mobile-accessories/',
                    ],
                '1' => [ 
                    'name' => 'گوشی موبایل',
                    'url' => 'search/category-mobile-phone/',
                    ],
                '2' => [ 
                    'name' => 'واقعیت مجازی',
                    'url' => 'search/category-mobile-accessories/?q=هدست%20واقعیت%20مجازی&entry=mm',
                    ],
                '3' => [ 
                    'name' => 'ساعت و مچ بند هوشمند',
                    'url' => 'search/category-wearable-gadget/',
                    ],
                '4' => [ 
                    'name' => 'هدفون، هدست، میکروفون',
                    'url' => 'search/category-headphone-headset-microphone/',
                    ],
                '5' => [ 
                    'name' => 'اسپیکر(بلندگو)',
                    'url' => 'search/category-speaker/',
                    ],
                '6' => [ 
                    'name' => 'هارد، فلش و ssd',
                    'url' => 'search/category-data-storage/',
                    ],
                '7' => [ 
                    'name' => 'دوربین',
                    'url' => 'search/category-camera/',
                    ],
                '8' => [ 
                    'name' => 'لوازم جانبی دوربین',
                    'url' => 'search/category-camera-accessories/',
                    ],
                '9' => [ 
                    'name' => 'دوربین دوچشمی و شکاری',
                    'url' => 'search/category-binoculars/',
                    ],
                '10' => [ 
                    'name' => 'تلسکوپ',
                    'url' => 'search/category-telescope/',
                    ],
                '11' => [ 
                    'name' => 'PS4, XBox و بازی',
                    'url' => 'search/category-game-console/',
                    ],
                '12' => [ 
                    'name' => 'کامپیوتر و تجهیزات جانبی',
                    'url' => 'search/category-computer-parts/',
                    ],
                '13' => [ 
                    'name' => 'اسپیکر(بلندگو)',
                    'url' => 'search/category-speaker/',
                    ],
                '14' => [ 
                    'name' => 'لپتاپ',
                    'url' => 'search/category-notebook-netbook-ultrabook/',
                    ],
                '15' => [ 
                    'name' => 'لوازم جانبی لپتاپ',
                    'url' => 'search/category-laptop-accessories/',
                    ],
                '16' => [ 
                    'name' => 'تبلت',
                    'url' => 'search/category-tablet/',
                    ],
                '17' => [ 
                    'name' => 'شارژر تبلت و موبایل',
                    'url' => 'search/category-car-charger/',
                    ],
                '18' => [ 
                    'name' => 'کیف، کاور و لوازم جانبی تبلت',
                    'url' => 'search/category-tablet-accessories/',
                    ],
                '19' => [ 
                    'name' => 'باتری',
                    'url' => 'search/category-battery-charger-and-accesories/',
                    ],
                '20' => [ 
                    'name' => 'دوربین های تحت شبکه',
                    'url' => 'search/category-network-cam/',
                    ],
                '21' => [ 
                    'name' => 'مودم و تجهیزات شبکه',
                    'url' => 'search/category-network/search/category-network/',
                    ],
                '22' => [ 
                    'name' => 'ماشین های اداری',
                    'url' => 'search/category-office-machines/',
                    ],
                '23' => [ 
                    'name' => 'کتابخوان و فیدیبوک',
                    'url' => 'search/category-ebook-reader/?q=%D9%81%DB%8C%D8%AF%DB%8C%D8%A8%D9%88%DA%A9&entry=mm',
                    ],
                '24' => [ 
                    'name' => 'کارت هدیه خرید از دیجی کالا',
                    'url' => 'main/dk-ds-gift-card/',
                    ],
                '25' => [ 
                    'name' => 'خرید شارژ و بسته اینترنت',
                    'url' => 'top-up/',
                    ],
                ],
            ],
        'personal-appliance' => [
            'name' => 'آرایشی، بهداشتی و سلامت',
            'method' => '',
            'sub_catagory' => [
                '0' => [ 
                    'name' => 'لوازم آرایشی',
                    'url' => 'search/category-beauty/',
                    ],
                '1' => [ 
                    'name' => 'لوازم بهداشتی',
                    'url' => 'search/category-hair-clipper/',
                    ],
                '2' => [ 
                    'name' => 'لوازم شخصی برقی',
                    'url' => 'search/category-electrical-personal-care/',
                    ],
                '3' => [ 
                    'name' => 'ست هدیه',
                    'url' => 'search/category-gift-set/',
                    ],
                '4' => [ 
                    'name' => 'عطر، ادکلن، اسپری و ست',
                    'url' => 'search/category-perfume-all/',
                    ],
                '5' => [ 
                    'name' => 'طلا، نقره و زیور آلات زنانه',
                    'url' => 'search/category-women-accessories/?q=%d8%b2%db%8c%d9%88%d8%b1%d8%a2%d9%84%d8%a7%d8%aa&entry=mm',
                    ],
                '6' => [ 
                    'name' => 'زیور آلات نقره مردانه',
                    'url' => 'search/category-men-silver-jewelry/',
                    ],
                '7' => [ 
                    'name' => 'ابزار سلامت و طبی',
                    'url' => 'search/category-health-care/',
                    ],
                ],
            ],
        'apparel' => [
            'name' => 'مد و پوشاک',
            'method' => '',
            'sub_catagory' => [
                '0' => [ 
                    'name' => 'مردانه',
                    'url' => 'search/category-mens-apparel/',
                    ],
                '1' => [ 
                    'name' => 'لباس مردانه',
                    'url' => 'search/category-men-clothing/',
                    ],
                '2' => [ 
                    'name' => 'کفش مردانه',
                    'url' => 'search/category-men-shoes/',
                    ],
                '3' => [ 
                    'name' => 'اکسسوری مردانه',
                    'url' => 'search/category-men-accessories/',
                    ],
                '4' => [ 
                    'name' => 'زنانه',
                    'url' => 'search/category-womens-apparel/',
                    ],
                '5' => [ 
                    'name' => 'لباس زنانه',
                    'url' => 'search/category-women-clothing/',
                    ],
                '6' => [ 
                    'name' => 'کفش زنانه',
                    'url' => 'search/category-women-shoes/',
                    ],
                '7' => [ 
                    'name' => 'اکسسوری زنانه',
                    'url' => 'search/category-women-accessories/',
                    ],
                '8' => [ 
                    'name' => 'زیورآلات زنانه',
                    'url' => 'search/category-women-jewelry/',
                    ],
                ],
            ],
            /*
        'vehicles' => [
            'name' => 'خودرو، ابزار و اداری',
            'method' => '',
            'sub_catagory' => [
                '0' => [ 
                    'name' => '',
                    'url' => 'search/category-mobile-phone/',
                    ],
                '1' => [ 
                    'name' => '',
                    'url' => '',
                    ],
                ],
            ],
        'apparel' => [
            'name' => 'مد و پوشاک',
            'method' => '',
            'sub_catagory' => [
                '0' => [ 
                    'name' => '',
                    'url' => 'search/category-mobile-phone/',
                    ],
                '1' => [ 
                    'name' => '',
                    'url' => '',
                    ],
                ],
            ],
        'home-and-kitchen' => [
            'name' => 'خانه و آشپزخانه',
            'method' => '',
            'sub_catagory' => [
                '0' => [ 
                    'name' => '',
                    'url' => 'search/category-mobile-phone/',
                    ],
                '1' => [ 
                    'name' => '',
                    'url' => '',
                    ],
                ],
            ],
        'book-and-media' => [
            'name' => 'کتاب، لوازم التحریر و هنر',
            'method' => '',
            'sub_catagory' => [
                '0' => [ 
                    'name' => '',
                    'url' => 'search/category-mobile-phone/',
                    ],
                '1' => [ 
                    'name' => '',
                    'url' => '',
                    ],
                ],
            ],
        'mother-and-child' => [
            'name' => 'اسباب بازی، کودک و نوزاد',
            'method' => '',
            'sub_catagory' => [
                '0' => [ 
                    'name' => '',
                    'url' => 'search/category-mobile-phone/',
                    ],
                '1' => [ 
                    'name' => '',
                    'url' => '',
                    ],
                ],
            ],
        'sport-entertainment' => [
            'name' => 'ورزش و سفر',
            'method' => '',
            'sub_catagory' => [
                '0' => [ 
                    'name' => '',
                    'url' => 'search/category-mobile-phone/',
                    ],
                '1' => [ 
                    'name' => '',
                    'url' => '',
                    ],
                ],
            ],
        'food-beverage' => [
            'name' => 'خوردنی و آشامیدنی',
            'method' => '',
            'sub_catagory' => [
                '0' => [ 
                    'name' => '',
                    'url' => 'search/category-mobile-phone/',
                    ],
                '1' => [ 
                    'name' => '',
                    'url' => '',
                    ],
                ],
            ],
            */
        ];

    public function webhook()
    {
        return $this->apiRequest('setWebhook', [
            'url' => str_replace('http', 'https', url(route('webhook')))
        ]) ? ['success'] : ['something wrong'];
    }

    public function index()
    {
        $update = json_decode(file_get_contents("php://input"));
        
        $message = $update->message;
        if( isset( $message->text ) )
        {
            if( isset( $message->text ) )
            {
                $numberOfMatch = 0;
                
                //SHOW RESULT OF SEARCH
                foreach($this->buttons as $catagory)
                {
                    foreach( $catagory['sub_catagory'] as $subCatagory )
                    {
                        if( $message->text == $subCatagory['name'] )
                        {
                            $result = $this->checkIsMember($update);
                            if( $result ){
                                $url = $subCatagory['url'];
                                $this->showSerachResult( $update, $url );
                            }
                            $numberOfMatch++;
                        }
                    }
                }
                
                //SHOW SUBCATAGORIES
                foreach($this->buttons as $catagory)
                {
                    if( $catagory['name'] == $message->text )
                    {
                        $result = $this->checkIsMember($update);
                        if( $result )
                            $this->showSubCatagories($update);
                            $numberOfMatch++;
                    }
                }
                
                switch( $message->text )
                {
                    case '/start':
                        $numberOfMatch++;
                        $result = $this->checkIsMember($update);
                        if( $result )
                            $this->showCatagories($update);
                        break;
                        
                    case $this->home['joined']['name']:
                        $numberOfMatch++;
                        $result = $this->checkIsMember($update);
                        if( $result )
                            $this->showCatagories($update);
                        break;
                        
                    case $this->home['mainPage']['name'];
                        $numberOfMatch++;  
                        $result = $this->checkIsMember($update);
                        if( $result )
                            $this->showCatagories($update);
                        break;
                    
                    case $this->home['manualSearch']['name'];
                        $numberOfMatch++;
                        $result = $this->checkIsMember($update);
                        if( $result )
                            $this->manualSearchText($update);
                        break;
                    
                        
                }
                //SHOW MANUAL SEARCH RESULT
                
                if( $numberOfMatch == 0 )
                {
                    $result = $this->checkIsMember($update);
                    if( $result ){
                        $q= $message->text;
                        $url = "search/";
                        $this->showSerachResult( $update, $url,$q );
                    }
                }
                
            }
        } 
    }
    
    public function test()
    {
        /*
        echo "<pre>";
        print_r($this->buttons);
        echo "</pre>";
        */
        $url = "search";
        $q = "کاغذ";
        
        $siteUrl = "https://www.digikala.com";
        $url = "$siteUrl/$url";
        $numberOfPage = 5;
        $content = "";
        if($q){
            $len = strlen($q);
            $s = "";
            for($m=0;$m<$len;$m++){
                $s = $s . urlencode($q[$m]);
            }
            $url = "$url/?q=$s";
        }
        
        if( strpos( $url, '?q=' ) ){
            for($i=1;$i<=$numberOfPage;$i++){
                $content = $content . file_get_contents("$url");
            }
        }
        else
        {
            for($i=1;$i<=$numberOfPage;$i++){
                $content = $content . file_get_contents("$url/?pageno=$i");
            }
        }
            
        /*
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $content  = mb_convert_encoding($content , 'HTML-ENTITIES', 'UTF-8');
        $html = $dom->loadHTML($content);
        $books = $dom->getElementsByTagName('ul');
        $finder = new \DomXPath($dom);
        $classname="c-product-box c-promotion-box js-product-box";
        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
        $txt = "";
        $numerOfResult = 0;
        foreach ($nodes as $node) {
            if( ( strpos( "$node->textContent", '٪' ) == true )  ){
                if( $node->childNodes[1]->tagName == 'a' ){            
                    $txt = $siteUrl . $node->childNodes[1]->attributes[5]->nodeValue;
                    $txt = $txt."\n".$node->childNodes[2]->childNodes[0]->nodeValue;
                    $txt = $txt."\n"."درصد تخفیف : ".$node->childNodes[2]->childNodes[2]->childNodes[0]->childNodes[0]->childNodes[1]->nodeValue ;
                    $txt = $txt."\n"."قمیت اولیه: ".$node->childNodes[2]->childNodes[2]->childNodes[0]->childNodes[0]->childNodes[0]->nodeValue;
                    $txt = $txt."\n"."قمیت پس از تخفیف: ".$node->childNodes[2]->childNodes[2]->childNodes[0]->childNodes[0]->childNodes[2]->nodeValue;
                    echo $txt, "<br>";
                    $numerOfResult++;
                }
            }
        }
        
        */
    }
    
    public function bon($update)
    {
        $message = $update->message;
        $txt = "هنوز عضو نیستی که\n لینک کانال:\n @special_sell";
        $this->apiRequest('sendMessage', [
            'chat_id' => $message->chat->id,
            'text' => $txt,
            'reply_markup' => json_encode( [
                    'keyboard' => [ 
                         [ 
                            [ 'text' => $this->home['joined']['name'] , 'callback_data' => '/start' ]
                         ]
                        ],
                    'resize_keyboard' => true,
                    ] )
        ]);
    }
    
    public function checkIsMember($update)
    {
        return true;
        
        $message = $update->message;
        $result = $this->apiRequest( 'getChatMember', [
                    'chat_id' => '@special_sell',
                    'user_id' => $message->chat->id,
                    ] );
        
        if( $result['result']['status'] == 'left' || $result['result']['status'] == 'kicked' || $result['result']['status'] == 'restricted' )
        {
            return $this->bon($update);
        }else{
            return true;
        }
        
    }
    
    public function showSerachResult( $update, $url, $q=null )
    {
        $message = $update->message;
        
        $iniMessage = "a person use robot";
        $this->apiRequest('sendMessage', [
            'chat_id' => "111055546",
            'text' => $iniMessage
        ]);
        
        $iniMessage = "یه مقدار طول میکشه. یه چند لحظه صبر کن...";
        $this->apiRequest('sendMessage', [
            'chat_id' => $message->chat->id,
            'text' => $iniMessage
        ]);
        
        $siteUrl = "https://www.digikala.com";
        $url = "$siteUrl/$url";
        $content = "";
        $numberOfPage = 3;
        if($q){
            $len = strlen($q);
            $s = "";
            for($m=0;$m<$len;$m++){
                $s = $s . urlencode($q[$m]);
            }
            $url = "$url/?q=$s";
        }
        
        if( strpos( $url, '?q=' ) ){
            for($i=1;$i<=$numberOfPage;$i++){
                $content = $content . file_get_contents("$url&pageno=$i");
            }
        }
        else
        {
            for($i=1;$i<=$numberOfPage;$i++){
                $content = $content . file_get_contents("$url/?pageno=$i");
            }
        }
        
        
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $content  = mb_convert_encoding($content , 'HTML-ENTITIES', 'UTF-8');
        $html = $dom->loadHTML($content);
        $books = $dom->getElementsByTagName('ul');
        $finder = new \DomXPath($dom);
        $classname="c-product-box c-promotion-box js-product-box";
        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
        $txt = "";
        $numerOfResult = 0;
        foreach ($nodes as $node) {
            if( ( strpos( "$node->textContent", '٪' ) == true )  ){
                if( $node->childNodes[1]->tagName == 'a' ){            
                    $txt = $siteUrl . $node->childNodes[1]->attributes[5]->nodeValue;
                    $txt = $txt."\n".$node->childNodes[2]->childNodes[0]->nodeValue;
                    $txt = $txt."\n"."درصد تخفیف : ".$node->childNodes[2]->childNodes[2]->childNodes[0]->childNodes[0]->childNodes[1]->nodeValue ;
                    $txt = $txt."\n"."قمیت اولیه: ".$node->childNodes[2]->childNodes[2]->childNodes[0]->childNodes[0]->childNodes[0]->nodeValue;
                    $txt = $txt."\n"."قمیت پس از تخفیف: ".$node->childNodes[2]->childNodes[2]->childNodes[0]->childNodes[0]->childNodes[2]->nodeValue;
                    
                    $this->apiRequest('sendMessage', [
                        'chat_id' => $message->chat->id,
                        'text' => $txt,
                        'reply_markup' => json_encode( [
                            'keyboard' => [ 
                                [ $this->home['mainPage']['name'] ]
                                ],
                            'resize_keyboard' => true,
                            ] )
                    ]);
                    $numerOfResult++;
                }
            }
        }
        
        if( $numerOfResult == 0 )
        {
            $txt = "حیف، چیزی پیدا نشد";
            
        }else
        {
            $txt = "خب، تموم شد";
        }
        $this->apiRequest('sendMessage', [
            'chat_id' => $message->chat->id,
            'text' => $txt,
            'reply_markup' => json_encode( [
                'keyboard' => [ 
                    [ $this->home['mainPage']['name'] ]
                    ],
                'resize_keyboard' => true,
                ] )
        ]);
    }
    
    public function manualSearchText($update)
    {
        $message = $update->message;
        
        $txt = "چیزی رو که میخوای جستجو کنی، تایپ کن بفرست";
        $this->apiRequest( 'sendMessage', [
            'chat_id' => $message->chat->id,
            'text' => $txt,
            'reply_markup' => json_encode( [
                'keyboard' => [ 
                    [ $this->home['mainPage']['name'] ]
                    ],
                'resize_keyboard' => true,
                ] )
            ] );
    }
    
    
    public function showCatagories($update)
    {
        $message = $update->message;
        
        $i=0;
        $n=-1;
        foreach( $this->buttons as $catagory )
        {
            if( $i%2 == 0 ){
                $n++;
                $i=0;
            }
            $keyboard[$n][$i] = $catagory['name'];
            $i++;
        }
        $keyboard[$n+1][0] = $this->home['manualSearch']['name'];
        $keyboard[$n+2][0] = $this->home['mainPage']['name'];
        
        $txt = "دسته بندی رو انتخاب کن\n !!دسته بندی های جدید به زودی اضافه میشه";
        $this->apiRequest( 'sendMessage', [
            'chat_id' => $message->chat->id,
            'text' => $txt,
            'reply_markup' => json_encode( [
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                ] )
            ] );
    }
    
    public function showSubCatagories($update)
    {
        $message = $update->message;
        
        $i=0;
        $n=-1;
        $subIndex = 0;
        foreach( $this->buttons as $catagory )
        {
            if( $catagory['name'] == $message->text )
            foreach( $catagory['sub_catagory'] as $subCatagory )
            {
                if( $i%2 == 0 ){
                    $n++;
                    $i=0;
                }
                $keyboard[$n][$i] = $subCatagory['name'];
                $i++;
            }
        }
        $keyboard[$n+1][0] = $this->home['manualSearch']['name'];
        $keyboard[$n+2][0] = $this->home['mainPage']['name'];
        
        $this->apiRequest( 'sendMessage', [
            'chat_id' => $message->chat->id,
            'text' => 'در کدوم بخش جستجو کنم؟',
            'reply_markup' => json_encode( [
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                ] )
            ] );
    }
    
}
