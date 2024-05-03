
    // Edit button click event listener
    document.getElementById("editButton").addEventListener("click", function() {
        // Show the edit form pop-up
        document.getElementById("editFormContainer").style.display = "block";

    });

	// Close button click event listener
    document.getElementById("closeEditForm").addEventListener("click", function() {
        // Close the edit form pop-up
        document.getElementById("editFormContainer").style.display = "none";
    });
	
	document.getElementById("editForm").addEventListener("submit", function(event) {

		var nameField = document.querySelector("input[name='newUsername']");
		var ageField = document.querySelector("input[name='newAge']");
		var passwordField = document.querySelector("input[name='newPw']");
    
		var errorMessage = "";

		// Validate password format
		var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,12}$/;
		if (!passwordPattern.test(passwordField.value)) {
			errorMessage += "Password must be 8-12 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).\n";
		}
		// Validate empty field
		if (nameField.value === "") {
			errorMessage += "Name field is required.\n";
		}
    
		if (ageField.value === "") {
			errorMessage += "Age field is required.\n";
		}
		//display error message
		if (errorMessage !== "") {
			event.preventDefault(); // Prevent form submission
			alert(errorMessage);
		}
	});


     // Logout button click event listener
    document.getElementById("logoutButton").addEventListener("click", function() {
        // Redirect to a-logout.php
        window.location.href = "a-logout.php";
		
    });
	
	    // Delete button click event listener
    document.getElementById("deleteButton").addEventListener("click", function() {
	   if (confirm("Are you sure you want to delete your account?")) {
            // Redirect to a-logout.php
			window.location.href = "a-deleteAcc.php";
        }
    });
	
	//Avoid user enter invalid num for age
	function quantityZero(event){
     var input = event.target;
		if (isNaN(input.value) || input.value <= 0){ //isNaN not a number
			input.value=1;
		}
	}
