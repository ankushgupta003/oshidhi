document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM content loaded"); // Check if DOMContentLoaded event is fired

    const addBarcodeBtn = document.getElementById("addBarcodeBtn");
    const barcodeInputs = document.getElementById("barcodeInputs");

    addBarcodeBtn.addEventListener("click", function () {
        const newBarcodeInput = document.createElement("div");
        newBarcodeInput.classList.add("barcodeInput");
        newBarcodeInput.innerHTML = `
            <label for="medicineName">Medicine Name:</label>
            <input type="text" class="medicineName">
            <button class="generateBarcodeBtn">Generate Barcode</button>
            <canvas class="barcodeCanvas"></canvas>
        `;
        barcodeInputs.appendChild(newBarcodeInput);
    });

    barcodeInputs.addEventListener("click", function (e) {
        if (e.target.classList.contains("generateBarcodeBtn")) {
            const inputField = e.target.previousElementSibling;
            const medicineName = inputField.value;
            if (medicineName.trim() !== "") {
                console.log("Medicine Name:", medicineName); // Check if medicine name is correctly obtained
                const canvas = e.target.nextElementSibling;
                generateBarcode(medicineName, canvas);
            } else {
                alert("Please enter a medicine name.");
            }
        }
    });

    function generateBarcode(medicineName, canvas) {
        JsBarcode(canvas, medicineName, {
            format: "CODE128",
            displayValue: true
        });
    }
});
