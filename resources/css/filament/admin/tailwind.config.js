import preset from "../../../../vendor/filament/filament/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                defaultWhite: "#ffffff",
                defaultBlue: "#0034ad",
                defaultGreen: "#12ba1e",
                defaultBlack: "#1e1926",
                defaultPurple: "#e39dff",
            },
        },
    },
    plugins: [
        function ({ addComponents }) {
            addComponents({
                // First gradient
                ".bg-gradient-cursor-design-1": {
                    background:
                        "linear-gradient(90deg, #0e1b05 0%, #3b5728 100%)",
                    cursor: "pointer",
                },
                // Second gradient
                ".bg-gradient-cursor-design-2": {
                    background:
                        "linear-gradient(90deg, #5e280b 0%, #f36c21 100%)",
                    cursor: "pointer",
                },
            });
        },
    ],
};
