<?php

namespace Webmagic\Dashboard\Docs\Traits;

trait CapitalsTrait {
    /**
     * @return string[]
     */
    protected function getCapitals(): array
    {
        return [
            1 => 'Kabul',
            2 => 'Tirana',
            3 => 'Algiers',
            4 => 'Andorra la Vella',
            5 => 'Luanda',
            6 => 'Saint John\'s',
            7 => 'Buenos Aires',
            8 => 'Yerevan',
            9 => 'Canberra',
            10 => 'Vienna',
            11 => 'Baku',
            12 => 'Nassau',
            13 => 'Manama',
            14 => 'Dhaka',
            15 => 'Bridgetown',
            16 => 'Minsk',
            17 => 'Brussels',
            18 => 'Belmopan',
            19 => 'Porto-Novo',
            20 => 'Thimphu',
            21 => 'La Paz',
            22 => 'Sarajevo',
            23 => 'Gaborone',
            24 => 'Brasilia',
            25 => 'Bandar Seri Begawan',
            26 => 'Sofia',
            27 => 'Ouagadougou',
            28 => 'Gitega',
            29 => 'Phnom Penh',
            30 => 'Yaounde',
            31 => 'Ottawa',
            32 => 'Praia',
            33 => 'Bangui',
            34 => 'N\'Djamena',
            35 => 'Santiago',
            36 => 'Beijing',
            37 => 'Bogota',
            38 => 'Moroni',
            39 => 'Brazzaville',
            40 => 'Kinshasa',
            41 => 'San Jose',
            42 => 'Yamoussoukro',
            43 => 'Zagreb',
            44 => 'Havana',
            45 => 'Nicosia',
            46 => 'Prague',
            47 => 'Copenhagen',
            48 => 'Djibouti',
            49 => 'Roseau',
            50 => 'Santo Domingo',
            51 => 'Dili',
            52 => 'Quito',
            53 => 'Cairo',
            54 => 'San Salvador',
            55 => 'Malabo',
            56 => 'Asmara',
            57 => 'Tallinn',
            58 => 'Addis Ababa',
            59 => 'Suva',
            60 => 'Helsinki',
            61 => 'Paris',
            62 => 'Libreville',
            63 => 'Banjul',
            64 => 'Tbilisi',
            65 => 'Berlin',
            66 => 'Accra',
            67 => 'Athens',
            68 => 'Saint George\'s',
            69 => 'Guatemala City',
            70 => 'Conakry',
            71 => 'Bissau',
            72 => 'Georgetown',
            73 => 'Port-au-Prince',
            74 => 'Tegucigalpa',
            75 => 'Budapest',
            76 => 'Reykjavik',
            77 => 'New Delhi',
            78 => 'Jakarta',
            79 => 'Tehran',
            80 => 'Baghdad',
            81 => 'Dublin',
            82 => 'Jerusalem*',
            83 => 'Rome',
            84 => 'Kingston',
            85 => 'Tokyo',
            86 => 'Amman',
            87 => 'Astana',
            88 => 'Nairobi',
            89 => 'Tarawa Atoll',
            90 => 'Pyongyang',
            91 => 'Seoul',
            92 => 'Pristina',
            93 => 'Kuwait City',
            94 => 'Bishkek',
            95 => 'Vientiane',
            96 => 'Riga',
            97 => 'Beirut',
            98 => 'Maseru',
            99 => 'Monrovia',
            100 => 'Tripoli',
            101 => 'Vaduz',
            102 => 'Vilnius',
            103 => 'Luxembourg',
            104 => 'Skopje',
            105 => 'Antananarivo',
            106 => 'Lilongwe',
            107 => 'Kuala Lumpur',
            108 => 'Male',
            109 => 'Bamako',
            110 => 'Valletta',
            111 => 'Majuro',
            112 => 'Nouakchott',
            113 => 'Port Louis',
            114 => 'Mexico City',
            115 => 'Palikir',
            116 => 'Chisinau',
            117 => 'Monaco',
            118 => 'Ulaanbaatar',
            119 => 'Podgorica',
            120 => 'Rabat',
            121 => 'Maputo',
            122 => 'Rangoon (Yangon)',
            123 => 'Windhoek',
            124 => 'no official capital',
            125 => 'Kathmandu',
            126 => 'Amsterdam',
            127 => 'Wellington',
            128 => 'Managua',
            129 => 'Niamey',
            130 => 'Abuja',
            131 => 'Oslo',
            132 => 'Muscat',
            133 => 'Islamabad',
            134 => 'Melekeok',
            135 => 'Panama City',
            136 => 'Port Moresby',
            137 => 'Asuncion',
            138 => 'Lima',
            139 => 'Manila',
            140 => 'Warsaw',
            141 => 'Lisbon',
            142 => 'Doha',
            143 => 'Bucharest',
            144 => 'Moscow',
            145 => 'Kigali',
            146 => 'Basseterre',
            147 => 'Castries',
            148 => 'Kingstown',
            149 => 'Apia',
            150 => 'San Marino',
            151 => 'Sao Tome',
            152 => 'Riyadh',
            153 => 'Dakar',
            154 => 'Belgrade',
            155 => 'Victoria',
            156 => 'Freetown',
            157 => 'Singapore',
            158 => 'Bratislava',
            159 => 'Ljubljana',
            160 => 'Honiara',
            161 => 'Mogadishu',
            162 => 'Pretoria (administrative)',
            163 => 'Juba',
            164 => 'Madrid',
            165 => 'Colombo',
            166 => 'Khartoum',
            167 => 'Paramaribo',
            168 => 'Mbabane',
            169 => 'Stockholm',
            170 => 'Bern',
            171 => 'Damascus',
            172 => 'Taipei',
            173 => 'Dushanbe',
            174 => 'Dar es Salaam',
            175 => 'Bangkok',
            176 => 'Lome',
            177 => 'Nuku\'alofa',
            178 => 'Port-of-Spain',
            179 => 'Tunis',
            180 => 'Ankara',
            181 => 'Ashgabat',
            182 => 'Vaiaku village, Funafuti province',
            183 => 'Kampala',
            184 => 'Kyiv',
            185 => 'Abu Dhabi',
            186 => 'London',
            187 => 'Washington, D.C.',
            188 => 'Montevideo',
            189 => 'Tashkent',
            190 => 'Port-Vila',
            191 => 'Vatican City',
            192 => 'Caracas',
            193 => 'Hanoi',
            194 => 'Sanaa',
            195 => 'Lusaka',
            196 => 'Harare',
        ];
    }
}
