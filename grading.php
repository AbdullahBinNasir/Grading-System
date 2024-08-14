<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grading System</title>
</head>

<body>
    <h1>Student Grading System</h1>
    <form id="gradingForm" method="POST">
        <label for="batch">Batch:</label>
        <select id="batch" name="batch">
            <option value="">Select Batch</option>
            <!-- Options populated dynamically -->
        </select>
        <br>
        <label for="semester">Semester:</label>
        <select id="semester" name="semester" disabled>
            <option value="">Select Semester</option>
            <!-- Options populated dynamically -->
        </select>
        <br>
        <label for="assignment">Assignment:</label>
        <select id="assignment" name="assignment" disabled>
            <option value="">Select Assignment</option>
            <!-- Options populated dynamically -->
        </select>
        <br>
        <br>
        <button type="button" id="fetchDetailsButton" disabled>Fetch Details</button>
    </form>

    <div id="students">
        <!-- Student details and grading form will be populated here -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchBatches();
        });

        function fetchBatches() {
            fetch('fetch_batches.php')
                .then(response => response.json())
                .then(data => {
                    const batchSelect = document.getElementById('batch');
                    batchSelect.innerHTML = '<option value="">Select Batch</option>';
                    data.forEach(batch => {
                        const option = document.createElement('option');
                        option.value = batch.id;
                        option.textContent = batch.name;
                        batchSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching batches:', error));
        }

        function fetchSemesters() {
            const batchId = document.getElementById('batch').value;
            if (batchId) {
                fetch(`fetch_semesters.php?batch_id=${batchId}`)
                    .then(response => response.json())
                    .then(data => {
                        const semesterSelect = document.getElementById('semester');
                        semesterSelect.innerHTML = '<option value="">Select Semester</option>';
                        data.forEach(semester => {
                            const option = document.createElement('option');
                            option.value = semester.id;
                            option.textContent = semester.name;
                            semesterSelect.appendChild(option);
                        });
                        semesterSelect.disabled = false; // Enable semester dropdown
                        document.getElementById('assignment').disabled = true; // Disable assignment dropdown
                        document.getElementById('fetchDetailsButton').disabled = true; // Disable fetch button
                    })
                    .catch(error => console.error('Error fetching semesters:', error));
            } else {
                document.getElementById('semester').innerHTML = '<option value="">Select Semester</option>';
                document.getElementById('semester').disabled = true;
                document.getElementById('assignment').innerHTML = '<option value="">Select Assignment</option>';
                document.getElementById('assignment').disabled = true;
                document.getElementById('fetchDetailsButton').disabled = true;
            }
        }

        function fetchAssignments() {
            const semesterId = document.getElementById('semester').value;
            if (semesterId) {
                fetch(`fetch_assignments.php?semester_id=${semesterId}`)
                    .then(response => response.json())
                    .then(data => {
                        const assignmentSelect = document.getElementById('assignment');
                        assignmentSelect.innerHTML = '<option value="">Select Assignment</option>';
                        data.forEach(assignment => {
                            const option = document.createElement('option');
                            option.value = assignment.id;
                            option.textContent = assignment.name;
                            assignmentSelect.appendChild(option);
                        });
                        assignmentSelect.disabled = false; // Enable assignment dropdown
                        document.getElementById('fetchDetailsButton').disabled = true; // Disable fetch button
                    })
                    .catch(error => console.error('Error fetching assignments:', error));
            } else {
                document.getElementById('assignment').innerHTML = '<option value="">Select Assignment</option>';
                document.getElementById('assignment').disabled = true;
                document.getElementById('fetchDetailsButton').disabled = true;
            }
        }

        function fetchStudents() {
            const batchId = document.getElementById('batch').value;
            const semesterId = document.getElementById('semester').value;
            const assignmentId = document.getElementById('assignment').value;

            if (batchId && semesterId && assignmentId) {
                fetch(`fetch_students.php?batch_id=${batchId}&semester_id=${semesterId}&assignment_id=${assignmentId}`)
                    .then(response => response.json())
                    .then(data => {
                        const studentsDiv = document.getElementById('students');
                        studentsDiv.innerHTML = '';

                        data.forEach(student => {
                            const studentDiv = document.createElement('div');
                            studentDiv.innerHTML = `<p>${student.name}</p><input type="text" name="grades[${student.id}]" placeholder="Grade">`;
                            studentsDiv.appendChild(studentDiv);
                        });

                        const saveButton = document.createElement('button');
                        saveButton.textContent = 'Save Grades';
                        saveButton.addEventListener('click', saveGrades);
                        studentsDiv.appendChild(saveButton);
                    })
                    .catch(error => console.error('Error fetching students:', error));
            }
        }

        function saveGrades() {
            const gradesForm = new FormData(document.getElementById('gradingForm'));
            fetch('save_grades.php', {
                method: 'POST',
                body: gradesForm
            })
            .then(response => response.json())
            .then(data => {
                alert('Grades saved successfully');
            })
            .catch(error => console.error('Error saving grades:', error));
        }

        document.getElementById('batch').addEventListener('change', fetchSemesters);
        document.getElementById('semester').addEventListener('change', fetchAssignments);
        document.getElementById('assignment').addEventListener('change', function() {
            document.getElementById('fetchDetailsButton').disabled = false; // Enable fetch button
        });
        document.getElementById('fetchDetailsButton').addEventListener('click', fetchStudents);
    </script>
</body>

</html>
