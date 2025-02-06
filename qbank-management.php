<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Upload and Publish Quiz</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f9f9f9;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .upload-container {
                width: 100%;
                max-width: 500px;
                background: #6a66668d;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                text-align: center;
            }

            .upload-container h2 {
                margin-bottom: 20px;
                font-size: 1.5rem;
                color: #333;
            }

            #excelFile {
                margin: 10px 0;
                font-size: 16px;
                padding: 10px;
                width: 90%;
                border: 1px solid #ddd;
                border-radius: 5px;
                background-color: #f9f9f9;
            }

            .submit-btn {
                display: block;
                margin: 20px auto;
                padding: 12px 24px;
                font-size: 16px;
                background: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                width: 100%;
                transition: background 0.3s ease;
            }

            .submit-btn:hover {
                background: #0056b3;
            }

            .submit-btn:disabled {
                background: #ebc6c6;
                cursor: not-allowed;
            }

            @media (max-width: 768px) {
                .upload-container {
                    padding: 15px;
                }

                .upload-container h2 {
                    font-size: 1.2rem;
                }

                .submit-btn {
                    font-size: 14px;
                    padding: 10px;
                    font-weight: bold;
                }
            }

            @media (max-width: 480px) {
                .upload-container h2 {
                    font-size: 1rem;
                }

                #excelFile {
                    font-size: 14px;
                }
            }
        </style>
    </head>
    <body>
        <div class="upload-container">
            <h2>Upload Quiz Questions</h2>
            <input type="file" id="excelFile" accept=".xlsx, .xls" />
            <button
                class="submit-btn"
                id="uploadBtn"
                onclick="uploadFile()"
                disabled
            >
                Upload and Publish
            </button>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
        <script>
            // Enable the button when a file is selected
            document
                .getElementById("excelFile")
                .addEventListener("change", function () {
                    document.getElementById("uploadBtn").disabled =
                        !this.files.length;
                });

            function uploadFile() {
                const file = document.getElementById("excelFile").files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        try {
                            const data = e.target.result;
                            const workbook = XLSX.read(data, {
                                type: "binary",
                            });
                            const sheet =
                                workbook.Sheets[workbook.SheetNames[0]];
                            const rows = XLSX.utils.sheet_to_json(sheet, {
                                header: 1,
                            });

                            // Parse rows into quiz data
                            const quizData = rows
                                .slice(1)
                                .filter(
                                    (row) =>
                                        row[1] &&
                                        row[2] &&
                                        row[3] &&
                                        row[4] &&
                                        row[5] &&
                                        row[6]
                                )
                                .map((row) => ({
                                    question: row[1],
                                    optionA: row[2],
                                    optionB: row[3],
                                    optionC: row[4],
                                    optionD: row[5],
                                    correctAnswer: row[6],
                                    explanation: row[7] || "", // Optional field
                                }));

                            if (quizData.length === 0) {
                                alert("No valid questions found in the file.");
                                return;
                            }

                            // Store quiz data
                            localStorage.setItem(
                                "quizData",
                                JSON.stringify(quizData)
                            );
                            localStorage.setItem("quizPublished", true);
                            alert("Quiz has been successfully published!");

                            // Redirect to the publish page
                            window.location.href = "publish.html";
                        } catch (error) {
                            alert(
                                "Error reading file. Please ensure it is a valid Excel file."
                            );
                            console.error("Error processing file:", error);
                        }
                    };
                    reader.readAsBinaryString(file);
                } else {
                    alert("Please select a file to upload.");
                }
            }
        </script>
    </body>
</html>