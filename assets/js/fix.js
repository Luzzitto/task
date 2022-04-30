document.addEventListener("DOMContentLoaded", function () {
    let firstInput = document.getElementsByTagName("input")[0];
    // Stackoverflow: https://stackoverflow.com/questions/511088/use-javascript-to-place-cursor-at-end-of-text-in-text-input-element
    firstInput.selectionStart = firstInput.selectionEnd = firstInput.value.length;
});
