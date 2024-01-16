<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .expandable-text {
      max-height: 40px;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }

    .expandable-text:hover {
      max-height: 200px;
    }
  </style>
</head>
<body>

  <div class="expandable-text">
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam.</p>
  </div>

</body>
</html>
