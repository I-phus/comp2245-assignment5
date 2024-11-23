document.addEventListener("DOMContentLoaded", () => {
  const lookupButton = document.getElementById("lookup");
  const countryInput = document.getElementById("country");
  const resultDiv = document.getElementById("result");

  lookupButton.addEventListener("click", async () => {
      console.log("Button Clicked");
      const countryName = countryInput.value.trim();

      if (!countryName) {
          resultDiv.innerHTML = "<p>Please enter a country name.</p>";
          return;
      }

      try {
          const response = await fetch(`world.php?country=${encodeURIComponent(countryName)}`);

          const data = await response.text();

          resultDiv.innerHTML = data; 
      } catch (error) {
          console.error("Error fetching data:", error);
          resultDiv.innerHTML = "<p>Something went wrong. Please try again.</p>";
      }
  });
});
