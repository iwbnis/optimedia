const themes = [
  //   THEME 1
  {
    "--color-primary": "rgb(229, 9, 20)",
    "--color-secondary": "#fff",
    "--color-tertiary": "0, 0, 0",
    "--color-tertiary-2": "78, 78, 78",
    "--color-tertiary-3": "rgb(229, 9, 20)",
  },
  //   THEME 2
  {
    "--color-primary": "rgb(3, 45, 111)",
    "--color-secondary": "#fff",
    "--color-tertiary": "5, 15, 107",
    "--color-tertiary-2": "130, 192, 255",
    "--color-tertiary-3": "rgb(40, 120, 250)",
  },
  //   THEME 3
  {
    "--color-primary": "rgb(255, 136, 0)",
    "--color-secondary": "#fff",
    "--color-tertiary": "33, 33, 33",
    "--color-tertiary-2": "255, 136, 0",
    "--color-tertiary-3": "rgb(255, 136, 0)",
  },
  //   THEME 4
  {
    "--color-primary": "rgb(230, 123, 198)",
    "--color-secondary": "#fff",
    "--color-tertiary": "69, 25, 82",
    "--color-tertiary-2": "230, 123, 198",
    "--color-tertiary-3": "rgb(230, 123, 198)",
  },
  //   THEME 5
  {
    "--color-primary": "rgb(255, 255, 255)",
    "--color-secondary": "rgb(44, 62, 80)",
    "--color-tertiary": "236, 240, 241",
    "--color-tertiary-2": "255, 255, 255",
    "--color-tertiary-3": "rgb(229, 9, 20)",
  },
];

function setTheme(themeNumber) {
  const selectedTheme = themes[themeNumber - 1];
  for (const variable in selectedTheme) {
    document.documentElement.style.setProperty(variable, selectedTheme[variable]);
  }
}

let DOMAINS_THEME = {
  "iptvcanada.vip": "1",
  "iptvquebec.vip": "2",
  "iptvuk.vip": "5",
  "choiceiptv.net": "3",
  "android-iptv-box.com": "4",
};

let currentDoamin = window.location.host;
let defaultTheme = "2";
let selectedTheme = DOMAINS_THEME[currentDoamin] || defaultTheme;

setTheme(selectedTheme); // Set the second theme
