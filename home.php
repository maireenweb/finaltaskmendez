<?
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Haven - Online Bookstore</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(to right, #6a11cb, #2575fc);
      color: white;
    }
    header {
      background-color: rgba(59, 89, 152, 0.9);
      padding: 15px;
      text-align: center;
      color: white;
      position: relative;
    }
    header h1 {
      margin: 0;
      font-size: 28px;
      font-weight: bold;
    }
    #search-bar {
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      padding: 10px;
      border-radius: 20px;
      border: none;
      width: 200px;
      transition: width 0.3s ease;
    }
    #search-bar:focus {
      width: 300px;
      outline: none;
    }
    nav {
      background-color: rgba(51, 51, 51, 0.9);
      display: flex;
      justify-content: center;
      padding: 10px;
    }
    nav a {
      padding: 14px 20px;
      text-decoration: none;
      color: white;
      text-transform: uppercase;
      font-weight: bold;
    }
    nav a:hover {
      background-color: #575757;
      border-radius: 5px;
    }
    .container {
      padding: 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .section {
      width: 80%;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      padding: 20px;
      margin-bottom: 30px;
    }
    .section h2 {
      color: #fff;
      text-align: center;
    }
    .book-list {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
      justify-content: center;
    }
    .book, .featured {
      background: white;
      color: black;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      min-height: 350px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      transition: transform 0.3s ease;
    }
    .book:hover, .featured:hover {
      transform: scale(1.05);
    }
    .book img, .featured img {
      width: 150px;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
    }
    .book button, .featured button {
      background-color: #3b5998;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 4px;
      cursor: pointer;
      transition: background 0.3s;
    }
    .book button:hover, .featured button:hover {
      background-color: #2d4373;
    }
    footer {
      text-align: center;
      padding: 10px;
      background-color: rgba(51, 51, 51, 0.9);
      color: white;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<header>
  <h1>Welcome to Book Haven</h1>
  <input type="text" id="search-bar" placeholder="Search for books...">
</header>

<nav>
  <a href="homehref.html">Home</a>
  <a href="bookhref.html">Books</a>
  <a href="D:\MENDEZ2E\category.html">Categories</a>
  <a href="D:\MENDEZ2E\featured.html">Featured</a>
  <a href="D:\MENDEZ2E\about.html">About Us</a>
  <a href="D:\MENDEZ2E\contact.html">Support</a>
  <a href="./logout.php">Log Out</a>
</nav>

<div class="container">
  <section id="books" class="section">
    <h2>Books</h2>
    <div class="book-list" id="book-list"></div>
  </section>
</div>

<footer>
  <p>&copy; Programmed and Developed by Maireen P.Mendez.</p>
</footer>

<script>
  const books = [
    { title: "The Great Gatsby", price: "₱399.00", image: "TGG.jpg" },
    { title: "To Kill a Mockingbird", price: "₱450.00", image: "Mockingbird_HERO_0.jpg" },
    { title: "1984", price: "₱380.00", image: "ph-11134207-7rasb-m0xyj354r6w305.jpg" },
    { title: "Harry Potter", price: "₱500.00", image: "hp.jpg" }
  ];
  
  function renderBooks() {
    const bookList = document.getElementById("book-list");
    bookList.innerHTML = "";
    books.forEach(book => {
      const bookDiv = document.createElement("div");
      bookDiv.classList.add("book");
      bookDiv.innerHTML = `
        <img src="${book.image}" alt="${book.title}">
        <h3>${book.title}</h3>
        <p>${book.price}</p>
        <button onclick="alert('${book.title} added to cart!')">Add to Cart</button>
      `;
      bookList.appendChild(bookDiv);
    });
  }

  renderBooks();

</script>
</body>
</html>
