module.exports = {
    purge: {
        content: [
            './resources/**/*.vue',
            './resources/**/*.blade.php'
        ],
        options: {
            whitelistPatterns: [
                /w-[0-9]+\/[0-9]+/,     // All variations of width classes we dynamically use in the view-builder
                /w-[0-9]+/,             // Different sizes used for icons
                /h-[0-9]+/,             // ^
                /bg-[a-z]+-[0-9]+/,     // Dynamically used colors in badges, buttons and so on
                /text-[a-z]+-[0-9]+/,   // ^
                /border-[a-z]+-[0-9]+/, // ^
                /grid-cols-[0-9]+/,     // Used for dashboard-widgets
                /fill-current/,
            ]
        }
    },
    // Disabling *-Opacity plugins reduces final css size by ~750kb. This only works in Tailwind > 1.4.3
    corePlugins: {
        textOpacity: false,
        backgroundOpacity: false,
        borderOpacity: false,
        placeholderOpacity: false,
        divideOpacity: false,
    },
    prefix: '',
    important: false,
    separator: ':',
    theme: {
        extend: {
            colors: {
                gray: {
                    /*50: '#FBFDFE',
                    100: '#F7FAFC',
                    150: '#F2F6FA',
                    200: '#EDF2F7',
                    250: '#E8EDF4',
                    300: '#E2E8F0',
                    400: '#CBD5E0',
                    500: '#A0AEC0',
                    600: '#718096',
                    650: '#5E6B7F',
                    700: '#4A5568',
                    750: '#3C4658',
                    800: '#2D3748',
                    850: '#242C3A',
                    900: '#1A202C',
                    950: '#0D1016',*/
                    50:  '#FBFDFE',
                    100: '#F1F5F9',
                    150: '#EAEFF5',
                    200: '#E2E8F0',
                    250: '#D9E0EA',
                    300: '#CFD8E3',
                    350: '#B3BFCF',
                    400: '#97A6BA',
                    450: '#7E8DA3',
                    500: '#64748B',
                    550: '#56657A',
                    600: '#475569',
                    650: '#3F4B5E',
                    700: '#364152',
                    750: '#2F3949',
                    800: '#27303F',
                    850: '#212837',
                    900: '#1A202E',
                    950: '#0D1017',
                }
            },
            spacing: {
                '0.5': '0.125rem',
                '1.5': '0.375rem',
                '2.5': '0.625rem',
                '3.5': '0.875rem',
                '72': '18rem',
                '80': '20rem',
            },
            maxHeight: {
                '0': '0',
                '1/4': '25%',
                '1/2': '50%',
                '3/4': '75%',
                'full': '100%',
                '64': '8rem',
                '128': '16rem',
                '256': '24rem',
            },
            minHeight: {
                '1': '0.25rem',
                '2': '0.5rem',
                '4': '1rem',
                '8': '2rem',
                '16': '4rem',
                '32': '6rem',
                '64': '8rem',
            },
            width: {
                '72': '18rem',
                '80': '20rem',
                '88': '22rem',
            }
        },
    },
    variants: {
        float: ['responsive', 'direction'],
        margin: ['responsive', 'direction', 'first', 'last'],
        padding: ['responsive', 'direction'],
        textAlign: ['responsive', 'direction']
    },
    plugins: [
        require('tailwindcss-dir')(),
    ],
}