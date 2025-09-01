console.clear();
window.onerror = function (message, source, lineno, colno, error) {
    return true; // Mencegah log error ke console
};
// console.log = function () {};
console.warn = function () { };
console.error = function () { };
console.info = function () { };
function showInfo() {
    const info = "eyJpbmZvIjoiV2Vic2l0ZSBJbmZvcm1hdGlvbiIsImRldGFpbCI6eyJBdXRob3IiOiJGYWphciBBamkgS3VzdW1hLCBTLktvbS4iLCJDb250YWN0IjoiZmFqaWt1c3VtYUBnbWFpbC5jb20iLCJPZmZpY2UiOiJEaW5hcyBMaW5na3VuZ2FuIEhpZHVwIEtvdGEgUGVrYWxvbmdhbiIsIkluc3RhZ3JhbSI6IkBmYWphcmFqaV9rdXN1bWEiLCAiV2Vic2l0ZSI6Imh0dHBzOi8vZmFqYXJhamlrdXN1bWEudmVyY2VsLmFwcCJ9fQ==";
    let json = JSON.parse(window.atob(info));
    console.group(json.info);
    for (let i in json.detail) {
        console.log(i + ":", json.detail[i]);
    }
    console.groupEnd();
}
showInfo();

// buat agar warna dari select option hitam tegas
const selectElements = document.querySelectorAll("select");
selectElements.forEach((select) => {
    select.style.color = "black";
    // select.style.fontWeight = "bold";
});
