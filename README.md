**OOP User Registration and Management**

This project is the result of my journey as a PHP developer transitioning from procedural programming to Object-Oriented Programming (OOP). After spending 4 years in the procedural PHP world, I wanted to challenge myself by building something more structured and maintainable. I started with basic register and login functions, but as I delved deeper into OOP, I expanded this project into a full User Registration and Management System.

This system allows users to register, log in, and manage their accounts, while admins have the ability to control and manage users through a dedicated admin dashboard. My goal with this project is not just to improve functionality but also to make the codebase more organized and scalable, without the complexities of MVC, which can be overwhelming for those still learning OOP—like me when I started this journey!

**Features:**

1. User Registration and Login: Users can register with unique credentials and log in securely.

2. Admin Dashboard: Admins can manage user accounts (add, edit, delete) and view user details.

3. Flash Messaging: Displays success or error messages to notify users/admins after actions such as registration, login, and account updates. Flash messages automatically disappear after 5 seconds.

4. Tailwind CSS: Integrated for styling the front-end, ensuring a clean and responsive design.

5. Secure Authentication: Admin and user login features ensure proper session handling and security. 


**My Journey:**

I started this project to push myself further into the world of OOP. While I initially named the repository "OOP-Register-and-Login-Functions," it quickly grew into something larger as I added an admin dashboard and full CRUD capabilities for user management. It’s been a fun challenge learning how to structure my code for maintainability, all while keeping things simple by avoiding MVC patterns for now.

As I continue learning, I’ll be adding new features and refining the system further.


**Technologies Used:**
1. PHP (OOP)
2. PDO (for database interactions)
3. MySQL (for storing user and admin data)
4. Tailwind CSS (for front-end styling)


**Setup Instructions**
**1. Clone the repository:**

  git clone https://github.com/Dikewonsi/OOP-User-Registration-and-Management.git


**2.Set up your database using the provided SQL file (oop_app.sql).**

**3.Update the database credentials in includes/database.php:**

**php**

private $host = "localhost";

private $db_name = "oop_app";

private $username = "root"; 

private $password = ""; 

**4. Start a local server using on your terminal:**

php -S localhost:8000

**5.Access the app on :localhost:8000" from your browser.**

**Contributions**

This is still a learning project for me, but if you’re interested in contributing, feel free to submit pull requests. Let’s learn and improve together!
