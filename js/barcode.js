document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM content loaded"); // Check if DOMContentLoaded event is fired

    const addMedicineBtn = document.getElementById("add-medicine");
    const medicineContainer = document.getElementById("medicine-container");

    addMedicineBtn.addEventListener("click", function () {
        const index = medicineContainer.querySelectorAll(".medicine-group").length;
        const newMedicineGroup = document.createElement("div");
        newMedicineGroup.classList.add("form-group", "medicine-group");
        newMedicineGroup.innerHTML = `
            <label for="medicine_name">Medicine Name</label>
            <input type="text" name="medicines[${index}][name]" required>
            <label for="medicine_dosage">Dosage</label>
            <input type="text" name="medicines[${index}][dosage]" placeholder="e.g., 1 tablet twice a day for 7 days" required>
            <button type="button" class="generateBarcodeBtn">Generate Barcode</button>
        `;
        medicineContainer.appendChild(newMedicineGroup);
    });

    medicineContainer.addEventListener("click", function (e) {
        if (e.target.classList.contains("generateBarcodeBtn")) {
            const inputField = e.target.previousElementSibling.previousElementSibling;
            const medicineName = inputField.value;
            if (medicineName.trim() !== "") {
                const canvas = document.createElement("canvas");
                generateBarcode(medicineName, canvas);
                e.target.parentElement.appendChild(canvas);
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
