<?php

return [
    'shop' => [
        'from' => 'from',
        'to' => 'to',
        'profile' => 'Profile',
        'cart-description' => 'items in cart, view bag',
        'cart-empty' => 'Your cart is empty',
        'browse-products' => 'Browse products'
    ],
    'sections' => [
        'annoucement-bar' => [
            'title' => 'Announcement',
            'description' => 'You can show your announcements here',
            'show_announcement' => 'Show annoucement',
            'show_announcement_info' => 'You can toggle the announcement bar using this checkbox',
            'default-content' => 'Announcement text here',
            'content-info' => 'The announcement text',
            'position' => 'Position',
            'position-left' => 'Left',
            'position-right' => 'Right',
            'position-center' => 'Center',
            'position-info' => 'The announcement bar position'
        ],

        'hero' => [
            'background-image' => 'Background Image',
            'height' => 'Height',
            'height-small' => 'Small',
            'height-medium' => 'Medium',
            'height-large' => 'Large',
            'content-position' => 'Content position',
            'content-position-top' => 'Top',
            'content-position-middle' => 'Middle',
            'content-position-bottom' => 'Bottom',
            'show-overlay' => 'Show overlay',
            'overlay-opacity' => 'Overlay opacity',
            'overlay-opacity-info' => 'Only applicable when overlay is enabled.',
            'blocks' => [
                'heading' => [
                    'title' => 'Heading',
                    'heading' => 'Heading',
                    'heading-default' => 'Your heading',
                    'size' => 'Size',
                    'size-small' => 'Small',
                    'size-medium' => 'Medium',
                    'size-large' => 'Large'
                ],
                'text' => [
                    'title' => 'Text',
                    'text' => 'Text',
                    'text-default' => 'Nisi nulla consectetur fugiat consectetur laborum id.'
                ],
                'button' => [
                    'title' => 'Button',
                    'text' => 'Text',
                    'text-default' => 'Button',
                    'link' => 'Link',
                    'style' => 'Style',
                    'style-primary' => 'Primary',
                    'style-secondary' => 'Secondary'
                ]
            ]
        ],

        'featured-category' => [
            'title' => 'Category',
            'heading' => 'Heading',
            'default-heading' => 'Featured Category',
            'products-to-show' => 'Products to show'
        ],

        'featured-products' => [
            'heading' => 'Heading',
            'default-heading' => 'Featured products',
            'subheading' => 'Subheading',
            'default-subheading' => 'Use this section to show off a few of your favourite products',
            'nb-products' => 'Number of products',
            'nb-products-info' => 'The number of products to display when no product block is added',
            'product-type' => 'Product type',
            'product-type-new' => 'New products',
            'product-type-featured' => 'Featured products',
            'product-type-info' => 'Applicable only when there are no product blocks added',
            'blocks' => [
                'product' => [
                    'title' => 'Product'
                ]
            ]
        ],

        'footer' => [
            'show-payment-methods' => 'Show payment methods',
            'show-shipping-methods' => 'Show shipping methods',
            'show-locale-selector' => 'Show language selector',
            'blocks' => [
                'about' => [
                    'title' => 'About',
                    'heading' => 'Heading',
                    'heading-default' => 'About our store',
                    'content' => 'Content',
                    'content-default' => 'Use this text area to tell your customers about your brand and vision. You can change it in the theme editor.'
                ],
                'quick-links' => [
                    'title' => 'Quick Links',
                    'heading' => 'Heading',
                    'heading-default' => 'Quick Links'
                ],
                'newsletter' => [
                    'title' => 'Newsletter',
                    'heading' => 'Heading',
                    'heading-default' => 'Newsletter',
                    'content' => 'Content',
                    'content-default' => 'A short sentence describing what someone will receive by subscribing'
                ]
            ]
        ],

        'product-details' => [
            'blocks' => [
                'title' => [
                    'title' => 'Title'
                ],
                'price' => [
                    'title' => 'Price'
                ],
                'stock' => [
                    'title' => 'Stock'
                ],
                'short-description' => [
                    'title' => 'Short description'
                ],
                'quantity-selector' => [
                    'title' => 'Quantity selector'
                ],
                'buy-buttons' => [
                    'title' => 'Buy buttons',
                    'show-buy-now' => 'Show buy now button'
                ],
                'description' => [
                    'title' => 'Description'
                ],
                'attributes' => [
                    'title' => 'Attributes'
                ],
                'variant-picker' => [
                    'title' => 'Variant picker'
                ],
                'downloadable-options' => [
                    'title' => 'Downloadable options'
                ],
                'grouped-options' => [
                    'title' => 'Grouped products options'
                ],
                'bundle-options' => [
                    'title' => 'Bundle options'
                ]
            ]
        ],

        'featured-category' => [
            'view-all' => 'View all'
        ],

        'checkout-page' => [
            'customer-has-account' => 'Already have an account ?',
            'login-text' => 'Sign in'
        ]
    ]
];
