// Function to format the number with dots every thousands
function formatNumberWithDots(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Function to format the number without dots
function formatNumberWithoutDots(string) {
    return string.replace(/\./g, "");
}

// Function to extract digits from string
function extractDigitsFromString(inputString) {
    return inputString.replace(/\D/g, "");
}

function addRupiah(string) {
    return "Rp. " + string;
}

// Function to update result fields
function updateResultField(type, value) {
    value = value ? formatNumberWithDots(value) : 0;
    if (type == 1) {
        $("#market-research-result").val(addRupiah(value));
        $("#R1").val(addRupiah(value));
    } else if (type == 2) {
        $("#preparation-result").val(addRupiah(value));
    } else if (type == 3) {
        $("#implementation-result").val(addRupiah(value));
    } else if (type == 4) {
        $("#evaluation-result").val(addRupiah(value));
    } else if (type == 5) {
        $("#infrastructure-result").val(addRupiah(value));
    } else if (type == 6) {
        $("#course-enrollment-result").val(value);
    } else if (type == 7) {
        $("#course-result").val(addRupiah(value));
        $("#course-fee-final").val(addRupiah(value));
    } else if (type == 8) {
        $("#certificate-enrollment-result").val(value);
    } else if (type == 9) {
        $("#certificate-result").val(addRupiah(value));
        $("#certificate-fee-final").val(addRupiah(value));
    }
}

function getFormula(calculationType) {
    return formulas.filter(
        (formula) => formula.calculation_type_id == calculationType
    )[0]["formula"];
}

// Save parameter values
function saveParameterValues(element) {
    element.value = Math.round(formatNumberWithoutDots(element.value));
    // console.log(element.name, element.value);

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "/update-param",
            data: {
                key: element.name,
                value: element.value,
            },
            success: function (response) {
                console.log(
                    "[calculations.js: saveParameterValues] SUCCESS:",
                    response + "," + element.name,
                    "," + element.value
                );
                resolve(response);
            },
            error: function (error) {
                console.error(
                    "[calculations.js: saveParameterValues] ERROR:",
                    error
                );
                resolve(error);
            },
        });
    });
}

function getCalculationData(formula) {
    // Get tokens from the formula
    const formulaWithoutSymbols = formula.replace(/[^\w\s]/g, "");
    const variableTokens = formulaWithoutSymbols.split(/\s+/);

    // console.log("Variable Tokens:", variableTokens);

    // Get data for every parameter in the formula
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "/get-calculation-data",
            data: {
                version: courseVersion["id"],
                variableTokens: variableTokens,
            },
            success: function (response) {
                console.log(
                    "[calculations.js: getCalculationData] SUCCESS:",
                    response
                );
                resolve(response);
            },
            error: function (error) {
                console.error(
                    "[calculations.js [" +
                        courseVersion["id"] +
                        "], getCalculationData] ERROR with formula [" +
                        formula +
                        "]: ",
                    error
                );
                reject(error);
            },
        });
    });
}

// Get parameter formula from DB
function getParameterFormula(parameterId) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "/get-parameter-formula",
            data: {
                id: parameterId,
            },
            success: function (response) {
                // console.log(
                //     "[calculations.js: getParameterFormula] SUCCESS:",
                //     response
                // );
                resolve(response);
            },
            error: function (error) {
                console.error(
                    "[calculations.js: getParameterFormula] ERROR:",
                    error
                );
                reject(error);
            },
        });
    });
}

// Define a function to check the validity of the result
function isValidResult(result) {
    // Add your own validation logic here
    // For example, check if the result is a number and not NaN or Infinity
    return typeof result === "number" && isFinite(result);
}

async function evaluateRoundUpFormula(formula, id) {
    console.log("[evaluateRoundUpFormula] for id [" + id + "]: " + formula);

    if (formula.includes("ROUNDUP")) {
        const roundUp =
            id == "1M1FREVSEM"
                ? "(1M1ACOC / (((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100)))"
                : "(1M2FCOC / (((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100)))";
        const string =
            id == "1M1FREVSEM"
                ? "ROUNDUP (1M1ACOC / (((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100)))"
                : "ROUNDUP (1M2FCOC / (((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100)))";

        // match[0] contains the entire matched substring
        // match[1] contains what's inside the parentheses

        let data = await getCalculationData(roundUp);
        let result = evaluateFormula(roundUp, data, 8);

        console.log(
            "[evaluateRoundUpFormula]: result after round up: " + result
        );

        // replace match[0] in formula with result
        formula = formula.toString().replace(string, result.toString());
        console.log("[evaluateRoundUpFormula]: Updated formula:", formula);
    } else {
        console.log("[evaluateRoundUpFormula]: Didn't match!");
    }

    return formula;
}

function evaluateFormula(formula, data, calcType) {
    const formulaWithoutSymbols = formula.replace(/[^\w\s]/g, "");
    const variableTokens = formulaWithoutSymbols.split(/\s+/);
    console.log("[evaluateFormula]: variable tokens:", variableTokens);

    // Loop through variable tokens and replace them in the formula
    let substitutedFormula = formula;
    variableTokens.forEach((token) => {
        const regex = new RegExp(token, "g"); // Create a regular expression with the global flag
        substitutedFormula = substitutedFormula.replace(regex, data[token]);
    });
    console.log("[evaluateFormula] Substituted Formula:", substitutedFormula);

    // Evaluate the substituted formula
    try {
        let result = 0;
        if (calcType == 6 || calcType == 8) {
            result = Math.ceil(eval(substitutedFormula));
        } else {
            result = Math.round(eval(substitutedFormula));
        }

        if (!isValidResult(result)) {
            result = "0"; // Fill with zero if the result is not valid
        }
        console.log(substitutedFormula + " = " + result);

        return result;
    } catch (error) {
        console.error(
            "Error evaluating formula [" + substitutedFormula + "]:",
            error
        );
    }

    return 0;
}

async function saveAllParametersValues(form) {
    if (
        form.id == "course-enrollment-form" ||
        form.id == "course-fee-form" ||
        form.id == "certificate-enrollment-form" ||
        form.id == "certificate-fee-form"
    ) {
        // Get all input elements within the form with a parameter id
        let elements = form.querySelectorAll("input");

        for (let i = 0; i < elements.length; i++) {
            if (elements[i].id != "_token") {
                await saveParameterValues(elements[i]);
            }
        }
    }
}

async function calculateAllParameters(form) {
    if (
        form.id == "course-enrollment-form" ||
        form.id == "course-fee-form" ||
        form.id == "certificate-enrollment-form" ||
        form.id == "certificate-fee-form"
    ) {
        // Get all input elements within the form with a parameter id
        let elements = form.querySelectorAll("input");

        try {
            for (const element of elements) {
                if (
                    element.id != "" &&
                    element.id != "calculation-type" &&
                    element.id != "status" &&
                    element.id != "course-result" &&
                    element.id != "desired-course-result"
                ) {
                    const res = await getParameterFormula(element.id);
                    if (res.length > 0) {
                        let paramFormula = res[0]["formula"];

                        paramFormula = await evaluateRoundUpFormula(
                            paramFormula,
                            element.id
                        );
                        const data = await getCalculationData(paramFormula);
                        const result = evaluateFormula(paramFormula, data);

                        console.log(
                            "calculateAllParameters: " +
                                element.id +
                                ": " +
                                result
                        );
                        if (result && result >= 0) {
                            element.text = formatNumberWithDots(result);
                            element.value = formatNumberWithDots(result);
                            await saveParameterValues(element);
                        }
                    }
                }
            }
            console.log("End of calculateAllParameters");
        } catch (error) {
            console.error("Error in calculateAllParameters:", error);
        }
    }
}

async function saveResultToDatabase(calcType, result, status) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "/update/" + courseVersion["id"],
            data: {
                "calculation-type": calcType,
                status: status ?? 0,
                result: result,
            },
            success: function (response) {
                // console.log(
                //     "[calculations.js: saveResultToDatabase] SUCCESS:"
                // );
                resolve(response);
            },
            error: function (error) {
                console.error(
                    "[calculations.js: saveResultToDatabase] ERROR:",
                    error
                );
                reject(error);
            },
        });
    });
}

async function calculateResultForm(form) {
    // Get the calculation type
    let calcType = form.find("#calculation-type").val();

    // Get formula
    let formula = getFormula(calcType);

    try {
        let data = await getCalculationData(formula);
        let result = evaluateFormula(formula, data, calcType);

        console.log(
            "calculateResultForm: [" +
                form.id +
                "]: " +
                formula +
                " = " +
                result
        );

        updateResultField(calcType, formatNumberWithDots(result));
        await saveResultToDatabase(calcType, result, 1);
    } catch (error) {
        console.error("Error during calculations:", error);
    }
}

// Result Calculations
async function calculateResults(inputElement) {
    // Find the parent form ID
    let form = $(inputElement).closest("form");
    // console.log("Form ID:", form.attr("id"));

    /* Start of Parameter Result Calculations */
    await calculateAllParameters(form[0]);

    /* Start of Result Calculations */
    await calculateResultForm(form);

    return form[0];
}

// Singular Parameters Calculations
async function calculateSingleResult(element) {
    $("#loading-container").removeClass("hidden");

    saveParameterValues(element).then(async () => {
        await calculateResults(element);

        $("#loading-container").addClass("hidden");
    });
}

// Singular Parameter for Course/Certificate Fee
async function calculateSingleResultForEnrollment(element) {
    // event.preventDefault();
    $("#loading-container").removeClass("hidden");

    let form = $(element).closest("form")[0];
    console.log("================" + form.id + "================");
    try {
        if (form.id == "course-fee-form") {
            await saveAllParametersValues($("#course-enrollment-form")[0]);
            await saveAllParametersValues($("#course-fee-form")[0]);

            await calculateAllParameters($("#course-fee-form")[0]);
            await calculateResultForm($("#course-fee-form"));
            await calculateAllParameters($("#course-fee-form")[0]);
            await calculateResultForm($("#course-enrollment-form"));
            location.reload();
        } else if (form.id == "certificate-fee-form") {
            await saveAllParametersValues($("#certificate-enrollment-form")[0]);
            await saveAllParametersValues($("#certificate-fee-form")[0]);

            await calculateAllParameters($("#certificate-enrollment-form")[0]);
            await calculateAllParameters($("#certificate-fee-form")[0]);
            await calculateResultForm($("#certificate-fee-form"));
            await calculateAllParameters($("#certificate-fee-form")[0]);
            await calculateResultForm($("#certificate-enrollment-form"));
            location.reload();
        }
    } catch (error) {
        console.log(error);
    }

    $("#loading-container").addClass("hidden");
}

async function calculateCourseFormResults(inputElement) {
    // Find the parent form ID
    let form = $(inputElement).closest("form");
    // console.log("Form ID:", form.attr("id"));

    /* Start of Parameter Result Calculations */

    await calculateAllParameters(form[0]);

    /* Start of Result Calculations */
    await calculateResultForm(form);
}

// Plural Parameters Calculations
async function calculatePluralResult(element) {
    multipleDiv = element.closest(".multiple");
    const costInput = multipleDiv.querySelectorAll(".cost");
    const totalInput = multipleDiv.querySelectorAll(".total");

    let cost = 0;
    let total = 0;
    for (let i = 0; i < costInput.length; i++) {
        let c = Math.round(formatNumberWithoutDots(costInput[i].value)) || 0;
        let t = Math.round(formatNumberWithoutDots(totalInput[i].value)) || 0;
        cost += c * t;
        total += t;
    }

    console.log(cost, total);

    let costRes = multipleDiv.querySelector(".cost-result");
    costRes.value = formatNumberWithDots(cost);
    await saveParameterValues(costRes);

    let totalRes = multipleDiv.querySelector(".total-result");
    totalRes.value = total;
    if (totalRes.name.startsWith("mulmed")) {
        $("#mulmed_num").text("Number of Multimedia: " + total);
    }
    await saveParameterValues(totalRes);

    await saveParameterValues(element);

    if (!$(element).prop("disabled")) {
        await calculateResults(costInput);
    }
}

// // Submit Form
// $("#save-market-research").click(function () {
//     $("#market-research-form").submit();

// });
// $("#save-preparation").click(function () {
//     $("#preparation-form").submit();
// });
// $("#save-implementation").click(function () {
//     $("#implementation-form").submit();
// });
// $("#save-evaluation").click(function () {
//     $("#evaluation-form").submit();
// });
// $("#save-infrastructure").click(function () {
//     $("#infrastructure-form").submit();
// });

// Add a click event listener to the "Yes" button
document.getElementById("yesBtn").addEventListener("click", function () {
    // Set flag and update button colors
    setFlag(true);
});

// Add a click event listener to the "No" button
document.getElementById("noBtn").addEventListener("click", function () {
    // Set flag and update button colors
    setFlag(false);
});

// Function to set the flag and update button colors
async function setFlag(flag) {
    // Update the flag value as needed, e.g., by sending an AJAX request

    // Update button colors based on the flag value
    const yesBtn = document.getElementById("yesBtn");
    const noBtn = document.getElementById("noBtn");

    if (flag) {
        yesBtn.style.backgroundColor = "#1c64f2";
        noBtn.style.backgroundColor = "gray";

        let form = $("#evaluation-form");
        form.find(".field").each(function () {
            $(this).prop("disabled", false);
            $(this).removeClass("bg-disabled-100");
        });
        flag = !flag;

        await calculateResultForm(form);
    } else {
        yesBtn.style.backgroundColor = "gray";
        noBtn.style.backgroundColor = "#dd2522";

        const form = document.getElementById("evaluation-form");
        form.querySelectorAll(".field").forEach((input) => {
            input.disabled = true;
            input.classList.add("bg-disabled-100");
        });
        flag = !flag;
        updateResultField(4, "0");
        await saveResultToDatabase(4, "0", 0);
    }
}

// Define a function to loop through forms and call calculateResults
async function calculateResultsForAllForms() {
    const forms = document.querySelectorAll("form"); // Get all forms on the page
    const order = [0, 1, 2, 3, 4, 6, 5, 8, 7]; // Desired order of indices

    // Use for...of loop to calculate the forms in the specified order
    for (const index of order) {
        const form = forms[index];
        // console.log("======== " + form.id + " ========");
        await calculateResults(form);
    }
}

// Define a function to loop through all inputs and format their values
function formatValuesForAllInputs() {
    const inputs = document.querySelectorAll("input"); // Get all input elements on the page

    inputs.forEach((input) => {
        const inputValue = input.value;
        const formattedValue = formatNumberWithDots(inputValue);
        input.value = formattedValue;
    });
}

async function seekCourseFee(calcType, targetResult, parameterToChange) {
    formula = getFormula(calcType);
    let data;

    try {
        data = await getCalculationData(formula);
    } catch (error) {
        console.error(
            "[calculations.js: seekCourseFee] Error fetching calculation data:",
            error
        );
    }

    let api;
    version = parseInt(courseVersion["course_version"]);

    if (calcType == 7) {
        // (((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * (100 + 1M1CPMP) / 100)
        data["target_course_fee"] = targetResult;
        data["R5"] = data["R5"];
        data["M1ACOC"] = data[`${version}M1ACOC`];
        data["M1CPMP"] = data[`${version}M1CPMP`];
        data["M1ANUEBEP"] = data[`${version}M1ANUEBEP`];

        api = "http://localhost:5000/calculate_course_fee";
    } else {
        // (((1M2FCOC + ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP * 1CCE)) / (1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * (100 + 1M2HPMP) / 100)
        data["target_certificate_fee"] = targetResult;
        data["M2FCOC"] = data[`${version}M2FCOC`];
        data["CCE"] = data[`${version}CCE`];
        data["M2CEESC"] = data[`${version}M2CEESC`];
        data["M2HPMP"] = data[`${version}M2HPMP`];
        data["M2DNUE"] = data[`${version}M2DNUE`];
        data["M2ANUEBEP"] = data[`${version}M2ANUEBEP`];

        api = "http://localhost:5000/calculate_certificate_fee";
    }

    try {
        // Make the AJAX request
        const response = await fetch(api, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        });

        const responseData = await response.json();

        if (responseData.success) {
            // Optimization was successful
            // console.log("result: " + Math.round(responseData.result));
            $(`#${parameterToChange}`)[0].value = Math.round(
                responseData.result
            );

            await saveParameterValues($(`#${parameterToChange}`)[0]);
            updateResultField(calcType, Math.round(responseData.achieved_fee));
            await saveResultToDatabase(
                calcType,
                Math.round(responseData.achieved_fee)
            );
            return true;
        } else {
            // Optimization was not successful
            console.log("Optimization failed:", responseData.message);
            return false;
        }
    } catch (error) {
        console.error("Error:", error);
    }

    return false;
}

function checkIfParameterUsed() {
    // Get all navigation items
    const navItems = document.querySelectorAll(".nav-item");

    // Iterate through the navigation items to find the selected one
    navItems.forEach((navItem, idx) => {
        if (idx < 5) {
            selectedTab = navItem.getAttribute("data-tab");

            let formula = getFormula(idx + 1);

            const formulaWithoutSymbols = formula.replace(/[^\w\s]/g, "");
            const variableTokens = formulaWithoutSymbols.split(/\s+/);

            let form = $("#" + selectedTab + "-form");
            version = parseInt(courseVersion["course_version"]);

            let inputs = form.find("input").filter(function () {
                return /^[A-Z0-9]+$/.test(this.id.replace("version", ""));
            });

            inputs.each((inputIdx, input) => {
                let inputId = input.id.trim();
                if (!variableTokens.includes(inputId)) {
                    $("#" + inputId + "_warning").show();
                }
            });
        }
    });
}

// Document Ready
$(document).ready(async function () {
    // Hide tab containers and show loading animation
    $(".tab-containers").hide();
    $(".loading-animation").show();

    // Check if all parameter used in formula
    checkIfParameterUsed();

    // Add event listener on input change to update the formatted value
    $("input").change(function (e) {
        e.preventDefault();
        const inputValue = formatNumberWithoutDots(e.target.value);
        const formattedValue = formatNumberWithDots(inputValue);
        e.target.value = formattedValue;
    });

    $(".cost").each(async function (idx, e) {
        await calculatePluralResult(e);
    });

    formatValuesForAllInputs();
    // try {
    //     await calculateResultsForAllForms();
    // } catch (error) {
    //     console.error("Error during calculations:", error);
    // }

    // After calculations and formatting are done
    // Show tab containers and hide loading animation
    $(".loading-animation").hide();
    $(".tab-containers").show();

    $("#course-seek-toggle").click(function () {
        // Toggle forms and UI elements
        $("#course-result-div").toggle("hidden");
        $("#course-seek-form").toggle("hidden");
    });

    $("#certificate-seek-toggle").click(function () {
        // Toggle forms and UI elements
        $("#certificate-result-div").toggle("hidden");
        $("#certificate-seek-form").toggle("hidden");
    });

    $("#recalculate-course").click(async function () {
        $("#loading-container").removeClass("hidden");

        const classList = $("#loading-container").attr("class");

        const desiredResult = parseFloat(
            extractDigitsFromString($("#desired-course-result")[0].value)
        );
        const goalSeekChanges = $(".course-seek-changes:first");

        let flag = await seekCourseFee(7, desiredResult, goalSeekChanges[0].id);

        if (flag) {
            await calculateAllParameters($("#course-fee-form")[0]);
            await calculateResultForm($("#course-enrollment-form"));

            $("#course-result-div").toggle("hidden");
            $("#course-seek-form").toggle("hidden");
            location.reload();
        } else {
            $("#course-seek-error").text("Optimization Failed");
        }

        $("#loading-container").addClass("hidden");
    });

    $("#recalculate-certificate").click(async function () {
        $("#loading-container").removeClass("hidden");

        const desiredResult = parseFloat(
            extractDigitsFromString($("#desired-certificate-result")[0].value)
        );
        const goalSeekChanges = $(".certificate-seek-changes:first");

        let flag = await seekCourseFee(9, desiredResult, goalSeekChanges[0].id);

        if (flag) {
            await calculateAllParameters($("#certificate-fee-form")[0]);
            await calculateResultForm($("#certificate-enrollment-form"));
            await calculateAllParameters($("#certificate-enrollment-form")[0]);
            await calculateAllParameters($("#certificate-fee-form")[0]);

            $("#certificate-result-div").toggle("hidden");
            $("#certificate-seek-form").toggle("hidden");
            location.reload();
        } else {
            $("#certificate-seek-error").text("Optimization Failed");
        }

        $("#loading-container").addClass("hidden");
    });

    $("#finalize-calculations").click(async function () {
        await saveResultToDatabase(7, $("#course-fee-final").val(), 1);
        await saveResultToDatabase(9, $("#certificate-fee-final").val(), 1);

        window.location.href = "/";
    });
});
