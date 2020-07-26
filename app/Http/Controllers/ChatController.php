<?php
namespace App\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;

// Modelos
use App\Models\Chat;

use DataTables;

class ChatController extends BaseController
{
    use ApiResponse;

    public function msg ()
    {

    }

    public function contacts ()
    {
        $contacts = [
            [
                'uid'=> 1,
                'displayName'=> 'Felecia Rower',
                'about'=> 'Cake pie jelly jelly beans. Marzipan lemon drops halvah cake. Pudding cookie lemon drops icing',
                'photoURL'=> '@assets/images/portrait/small/avatar-s-1.jpg',
                'status'=> 'offline'
            ],
            [
                'uid'=> 2,
                'displayName'=> 'Adalberto Granzin',
                'about'=> 'Toffee caramels jelly-o tart gummi bears cake I love ice cream lollipop. Sweet liquorice croissant candy danish dessert icing. Cake macaroon gingerbread toffee sweet.',
                'photoURL'=> '@assets/images/portrait/small/avatar-s-2.jpg',
                'status'=> 'do not disturb'
            ],
            [
                'uid'=> 3,
                'displayName'=> 'Joaquina Weisenborn',
                'about'=> 'Soufflé soufflé caramels sweet roll. Jelly lollipop sesame snaps bear claw jelly beans sugar plum sugar plum.',
                'photoURL'=> '@assets/images/portrait/small/avatar-s-3.jpg',
                'status'=> 'do not disturb'
            ],
            [
                'uid'=> 4,
                'displayName'=> 'Verla Morgano',
                'about'=> 'Chupa chups candy canes chocolate bar marshmallow liquorice muffin. Lemon drops oat cake tart liquorice tart cookie. Jelly-o cookie tootsie roll halvah.',
                'photoURL'=> '@assets/images/portrait/small/avatar-s-4.jpg',
                'status'=> 'online'
            ],
            [
                'uid'=> 5,
                'displayName'=> 'Margot Henschke',
                'about'=> 'Cake pie jelly jelly beans. Marzipan lemon drops halvah cake. Pudding cookie lemon drops icing',
                'photoURL'=> '@assets/images/portrait/small/avatar-s-5.jpg',
                'status'=> 'do not disturb'
            ],
            [
                'uid'=> 6,
                'displayName'=> 'Sal Piggee',
                'about'=> 'Toffee caramels jelly-o tart gummi bears cake I love ice cream lollipop. Sweet liquorice croissant candy danish dessert icing. Cake macaroon gingerbread toffee sweet.',
                'photoURL'=> '@assets/images/portrait/small/avatar-s-6.jpg',
                'status'=> 'online'
            ],
            [
                'uid'=> 7,
                'displayName'=> 'Miguel Guelff',
                'about'=> 'Biscuit powder oat cake donut brownie ice cream I love soufflé. I love tootsie roll I love powder tootsie roll.',
                'photoURL'=> '@assets/images/portrait/small/avatar-s-7.jpg',
                'status'=> 'online'
            ],
            [
                'uid'=> 8,
                'displayName'=> 'Mauro Elenbaas',
                'about'=> 'Bear claw ice cream lollipop gingerbread carrot cake. Brownie gummi bears chocolate muffin croissant jelly I love marzipan wafer.',
                'photoURL'=> '@assets/images/portrait/small/avatar-s-8.jpg',
                'status'=> 'away'
            ],
            [
                'uid'=> 9,
                'displayName'=> 'Bridgett Omohundro',
                'about'=> 'Gummies gummi bears I love candy icing apple pie I love marzipan bear claw. I love tart biscuit I love candy canes pudding chupa chups liquorice croissant.',
                'photoURL'=> '@assets/images/portrait/small/avatar-s-9.jpg',
                'status'=> 'offline'
            ],
            [
                'uid'=> 10,
                'displayName'=> 'Zenia Jacobs',
                'about'=> 'Cake pie jelly jelly beans. Marzipan lemon drops halvah cake. Pudding cookie lemon drops icing',
                'photoURL'=> '@assets/images/portrait/small/avatar-s-10.jpg',
                'status'=> 'away'
            ]
        ];

        return $this->showResponse($contacts);
    }

    public function chatContacts ()
    {
        return $this->contacts();
    }

    public function chats ()
    {
        $chat = [
            [
                'isPinned' => true,
                'msg' => [
                    [
                        'textContent' => 'How can we help? We\'re here for you!',
                        'time' => 'Mon Dec 10 2018 07:45:00 GMT+0000 (GMT)',
                        'isSent' => true,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'Hey John, I am looking for the best admin template. Could you please help me to find it out?',
                        'time' => 'Mon Dec 10 2018 07:45:23 GMT+0000 (GMT)',
                        'isSent' => false,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'It should be Bootstrap 4 compatible.',
                        'time' => 'Mon Dec 10 2018 07:45:55 GMT+0000 (GMT)',
                        'isSent' => false,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'Absolutely!',
                        'time' => 'Mon Dec 10 2018 07:46:00 GMT+0000 (GMT)',
                        'isSent' => true,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'Modern admin is the responsive bootstrap 4 admin template.!',
                        'time' => 'Mon Dec 10 2018 07:46:05 GMT+0000 (GMT)',
                        'isSent' => true,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'Looks clean and fresh UI.',
                        'time' => 'Mon Dec 10 2018 07:46:23 GMT+0000 (GMT)',
                        'isSent' => false,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'It\'s perfect for my next project.',
                        'time' => 'Mon Dec 10 2018 07:46:33 GMT+0000 (GMT)',
                        'isSent' => false,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'How can I purchase it?',
                        'time' => 'Mon Dec 10 2018 07:46:43 GMT+0000 (GMT)',
                        'isSent' => false,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'Thanks, from ThemeForest.',
                        'time' => 'Mon Dec 10 2018 07:46:53 GMT+0000 (GMT)',
                        'isSent' => true,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'I will purchase it for sure. 👍',
                        'time' => 'Mon Dec 10 2018 07:47:00 GMT+0000 (GMT)',
                        'isSent' => false,
                        'isSeen' => false
                    ]
                ]
            ],
            [
                'isPinned' => false,
                'msg' => [
                    [
                        'textContent' => 'Hi',
                        'time' => 'Mon Dec 10 2018 07:45:00 GMT+0000 (GMT)',
                        'isSent' => true,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'Hello. How can I help You?',
                        'time' => 'Mon Dec 11 2018 07:45:15 GMT+0000 (GMT)',
                        'isSent' => false,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'Can I get details of my last transaction I made last month?',
                        'time' => 'Mon Dec 11 2018 07:46:10 GMT+0000 (GMT)',
                        'isSent' => true,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'We need to check if we can provide you such information.',
                        'time' => 'Mon Dec 11 2018 07:45:15 GMT+0000 (GMT)',
                        'isSent' => false,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'I will inform you as I get update on this.',
                        'time' => 'Mon Dec 11 2018 07:46:15 GMT+0000 (GMT)',
                        'isSent' => false,
                        'isSeen' => true
                    ],
                    [
                        'textContent' => 'If it takes long you can mail me at my mail address.',
                        'time' => 'Mon Dec 11 2018 07:46:20 GMT+0000 (GMT)',
                        'isSent' => true,
                        'isSeen' => false
                    ]
                ]
            ]
        ];

        return $this->showResponse($chat);
    }

    public function markAllSeen ()
    {

    }

    public function setPinned ()
    {

    }
}
