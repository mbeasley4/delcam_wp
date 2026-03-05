/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
	'./**/*.php',
	'!./vendor/**/*.php',
	'!./node_modules/**',
	],
	theme: {
		extend: {
			colors: {
				navy:    '#0B2545',
				blue:    '#1E5FA8',
				sky:     '#2E7DD1',
				accent:  '#1A8FE3',
				gold:    '#C8922A',
				'gold-light': '#E8B84B',
				light:   '#EEF4FB',
				mid:     '#6B7B8D',
				dark:    '#0A1E35',
			},
			fontFamily: {
				display: ['"Bebas Neue"', 'cursive'],
				sans:    ['"DM Sans"', 'sans-serif'],
				mono:    ['"JetBrains Mono"', 'monospace'],
			},
		},
	},
	plugins: [],
};
