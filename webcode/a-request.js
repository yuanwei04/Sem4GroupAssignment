  // Select the "Add" and "Remove" buttons and the container for food items
  const addFoodItemButton = document.getElementById("add-food-item-btn");
  const removeFoodItemButton = document.getElementById("remove-food-item-btn");
  const foodItemsContainer = document.getElementById("food-items-container");
  let rowCount = 1; // Start with 1 row
	

	addFoodItemButton.addEventListener("click", function(event) {
	  event.preventDefault(); // Prevent the default form submission behavior  
	  
	// Check if the maximum row count hasn't been reached (5 rows)
	if(rowCount<5){
		rowCount++; // Increment the row count
		// Create a new food item section
		const newFoodItem = document.createElement("div");
		newFoodItem.className = "food-item";
		newFoodItem.innerHTML = `
		<label>Food Item ${rowCount}:</label>
		<div class="flexDonate">
		  <div class="flexInputBox">
			<select name="itemDonate[]">
				<option value="Bread">Bread</option>
				<option value="Rice">Rice</option>
				<option value="Canned Food">Canned Food</option>
				<option value="Cooking Oil">Cooking Oil</option>
				<option value="Cereal">Cereal</option>
			</select>
			<p class="error"></p>
		  </div>
			<div class="flexInputBox">
				<input type="number" name="itemQty[]" placeholder="Quantity" min="1" oninput="quantityZero(event)"/>
				<p class="error"></p>
			</div>
		</div>
		`;
		 // Append the new food item section to the container
		foodItemsContainer.appendChild(newFoodItem);
	
	}
	else{
		// Display an alert if the maximum limit has been reached
		alert("You can add up to 5 food items.");
	}
		
  });

  removeFoodItemButton.addEventListener("click", function(event) {
	  event.preventDefault(); // Prevent the default form submission behavior  

    const foodItems = foodItemsContainer.querySelectorAll(".food-item");
	const lastFoodItems = foodItems[foodItems.length - 1];// Select the last food item
	
	// Check if there's more than one food item section
    if (foodItems.length > 1) {
	  // Remove the last food item section	
      foodItemsContainer.removeChild(lastFoodItems);
	      rowCount--; // Decrement the row count
    }
	else{
		alert("At least one food item is required.");
	}
  });
  
    function quantityZero(event){
    var input = event.target;
		if (isNaN(input.value) || input.value <= 0){ //isNaN not a number
			input.value=1;
		}
	}


