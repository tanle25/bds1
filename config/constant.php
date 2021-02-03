<?php
return [
    'province_name' => env('APP_PROVINCE', 'Thanh Hóa'),
    'price_type' => [
        '0' => [
            'front_view' => 'Thỏa thuận',
            'back_view' => 'Thỏa thuận',
        ],
        '1' => [
            'front_view' => '',
            'back_view' => 'Mặc định',
        ],
        '2' => [
            'front_view' => '/ m²',
            'back_view' => 'Giá/m²',
        ],
        '3' => [
            'front_view' => '/ tháng',
            'back_view' => 'Giá/tháng',
        ],
    ],
    'realty_post_status' => [
        '1' => 'Tin chưa duyệt',
        '2' => 'Đã thanh toán',
        '3' => 'Tin đã duyệt',
        '4' => 'Tin rác',
    ],
    'provinces' => explode(',', env('PROVINCE_ID', "38")),
    'realty_post_type' => [
        '1' => [
            'name' => 'Bán',
            'slug' => 'ban',
            'realty_type_list' => [1, 2, 3, 4, 5, 6, 7, 12],
            'price_range' => [0, 500, 800, 1000, 2000, 3000, 5000, 7000, 10000, 20000, 30000], //Đơn giá x1000.000
        ],
        '2' => [
            'name' => 'Cho thuê',
            'slug' => 'cho-thue',
            'realty_type_list' => [1, 2, 8, 9, 10, 11, 12],
            'price_range' => [0, 1, 3, 5, 10, 40, 70, 100],
        ],
    ],

    'realty_area_range' => [0, 30, 50, 80, 100, 150, 200, 250, 300, 500],

    'realty_type' => [
        '1' => [
            'name' => 'Chung cư',
            'slug' => 'chung-cu',
        ],
        '2' => [
            'name' => 'Nhà riêng',
            'slug' => 'nha-rieng',
        ],

        '3' => [
            'name' => 'Nhà biệt thự liền kề',
            'slug' => 'nha-biet-thu-lien-ke',
        ],

        '4' => [
            'name' => 'Nhà mặt phố',
            'slug' => 'nha-mat-pho',
        ],

        '5' => [
            'name' => 'Đất nền',
            'slug' => 'dat-nen',
        ],

        '6' => [
            'name' => 'Trang trại, Khu nghỉ dưỡng',
            'slug' => 'trang-trai-khu-nghi-duong',
        ],

        '7' => [
            'name' => 'Kho, nhà xưởng',
            'slug' => 'kho-nha-xuong',
        ],

        // Cho thuê
        '8' => [
            'name' => 'Nhà trọ, phòng trọ',
            'slug' => 'nha-tro-phong-tro',
        ],

        '9' => [
            'name' => 'Văn phòng',
            'slug' => 'van-phong',
        ],

        '10' => [
            'name' => 'Cửa hàng, ki ốt',
            'slug' => 'cua-hang-kiot',
        ],

        '11' => [
            'name' => 'Kho, nhà xưởng',
            'slug' => 'kho-nha-xuong',
        ],

        '12' => [
            'name' => 'Bất động sản khác',
            'slug' => 'bat-dong-san-khac',
        ],
    ],

    'project_type' => [
        '1' => [
            'name' => 'Căn hộ chung cư',
            'slug' => 'can-ho-chung-cu',
        ],
        '2' => [
            'name' => 'Cao ốc văn phòng',
            'slug' => 'cao-oc-van-phong',
        ],
        '3' => [
            'name' => 'Trung tâm thương mại',
            'slug' => 'khu-do-thi-moi',
        ],
        '4' => [
            'name' => 'Khu phức hợp',
            'slug' => 'khu-phuc-hop',
        ],
        '5' => [
            'name' => 'Nhà ở xã hội',
            'slug' => 'nha-o-xa-hoi',
        ],
        '6' => [
            'name' => 'Khu nghỉ dưỡng, sinh thái',
            'slug' => 'khu-nghi-duong-sinh-thai',
        ],
        '7' => [
            'name' => 'Khu công nghiệp',
            'slug' => 'khu-cong-nghiep',
        ],
        '8' => [
            'name' => 'Biệt thự liền kề',
            'slug' => 'biet-th-lien-ke',
        ],

        '9' => [
            'name' => 'Dự án khác',
            'slug' => 'du-an-khac',
        ],
    ],

    'bill_status' => [
        '1' => [
            'name' => 'Chưa duyệt',
        ],
        '2' => [
            'name' => 'Đã duyệt',
        ],
        '3' => [
            'name' => 'Đã hủy',
        ],
    ],

    'direction' => [
        '1' => ['name' => 'Đông'],
        '2' => ['name' => 'Tây'],
        '3' => ['name' => 'Nam'],
        '4' => ['name' => 'Bắc'],
        '5' => ['name' => 'Đông Bắc'],
        '6' => ['name' => 'Đông Nam'],
        '7' => ['name' => 'Tây Bắc'],
        '8' => ['name' => 'Tây Nam'],

    ],

    'project_status' => [
        '1' => ['name' => 'Đang xây dựng'],
        '2' => ['name' => 'Đang mở bán'],

    ],

    'advertisment' => [
        'type' => [
            '1' => [
                'name' => 'Quảng cáo dọc',
            ],
            '2' => [
                'name' => 'Quảng cáo ngang',
            ],
            '3' => [
                'name' => 'Quảng cáo dọc mobile',
            ],
            '4' => [
                'name' => 'Quảng cáo ngang mobile',
            ],
        ],

        'status' => [
            '1' => [
                'name' => 'Đang hoạt động',
            ],
            '2' => [
                'name' => 'Dừng hoạt động',
            ],
        ],
    ],

    'partner' => [
        'areas_of_expertise' => [
            '1' => [
                'name' => 'Chủ đầu tư',
            ],
            '2' => [
                'name' => 'Thi công xây dựng',
            ],
            '3' => [
                'name' => 'Tư vấn thiết kế',
            ],
            '4' => [
                'name' => 'Sàn giao dịch bất động sản',
            ],
            '5' => [
                'name' => 'Trang trí nội thất',
            ],
            '6' => [
                'name' => 'Vật liệu xây dựng',
            ],
            '7' => [
                'name' => 'Tài chính pháp lý',
            ],
            '8' => [
                'name' => 'Các lĩnh vực khác',
            ],
        ],
        'rank' => [
            '1' => [
                'name' => 'Đối tác nổi bật',
            ],
            '2' => [
                'name' => 'Đối tác khác',
            ],
        ],
    ],

    'province_type' => [
        'tinh' => 'Tỉnh',
        'thanh-pho' => 'Thành phố',
    ],

    'district_type' => [
        'huyen' => 'Huyện',
        'quan' => 'Quận',
        'thanh-pho' => 'Thành phố',
        'thi-xa' => 'Thị xã',
    ],

    'commune_type' => [
        'xa' => 'Xã',
        'phuong' => 'Phường',
        'thi-tran' => 'Thị trấn',
    ],
];