document.addEventListener("DOMContentLoaded", () => {
  const lookupButton = document.getElementById("lookup");
  const lookupCitiesButton = document.getElementById("lookupCities");
  const countryInput = document.getElementById("country");
  const resultDiv = document.getElementById("result");

  const fetchResults = async (lookupType) => {
    const countryName = countryInput.value.trim();

    if (!countryName) {
        resultDiv.innerHTML = "<p>Please enter a country name.</p>";
        return;
    }

    try {
        const response = await fetch(`world.php?country=${encodeURIComponent(countryName)}&lookup=${lookupType}`);

        const data = await response.text();

        resultDiv.innerHTML = data; 
    } catch (error) {
        console.error("Error fetching data:", error);
        resultDiv.innerHTML = "<p>Something went wrong. Please try again.</p>";
    }
  };

  lookupButton.addEventListener("click", () => {
      console.log("Country Lookup Button Clicked");
      fetchResults("country");
  });

  lookupCitiesButton.addEventListener("click", () => {
      console.log("Cities Lookup Button Clicked");
      fetchResults("cities");
  });
});
