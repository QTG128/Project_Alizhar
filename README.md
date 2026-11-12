# IT Inventory & Damage Reporting Module - Al Izhar Pondok Labu

## 📌 Project Overview (Internship Project)
This project is an additional web-based module (add-on) developed to integrate seamlessly into Al Izhar Pondok Labu's existing in-house school system. 

The primary goal is to streamline and accelerate the IT equipment maintenance workflow. Teachers can report faulty devices (e.g., projectors, monitors) specific to their classrooms (e.g., SD 204-C), and the IT team instantly receives these tickets on their dashboard along with automated stock recommendations for replacements available in the warehouse.

---

## 🛠️ Required Software & Tools (Prerequisites)
Before you start, make sure you have installed the following software on your computer:
1. XAMPP (or Laragon) - To run local PHP server and MySQL database.
2. Visual Studio Code (VS Code) - As our code editor.
3. Git (or Git Portable) - For version control and downloading the project.
4. Web Browser - Google Chrome or Microsoft Edge.

---

## 🚀 Step 1: How to Download the Project for the First Time (No prior GitHub experience needed!)
If you don't have the project on your laptop yet, follow these steps:

1. Download and install Git from https://git-scm.com/
2. Open your terminal (Git Bash, Command Prompt, or PowerShell).
3. Navigate to your XAMPP's htdocs folder by typing:
   cd C:\xampp\htdocs
   (Note: Change C: to G: or your actual XAMPP installation drive).
4. Clone (download) the repository by typing:
   git clone https://github.com/QTG128/Project_Alizhar.git
   A new folder named Project_Alizhar will automatically appear inside your htdocs directory.

---

## 🗄️ Step 2: Database Setup
1. Open your XAMPP Control Panel and click Start on Apache and MySQL.
2. Open your web browser and go to: http://localhost/phpmyadmin/
3. Click on New on the left sidebar to create a new database.
4. Name the database strictly: db_alizhar and click Create.
5. Click on the newly created db_alizhar database, then click on the Import tab at the top.
6. Click Choose File and select the db_alizhar.sql file located inside your local Project_Alizhar folder.
7. Scroll down and click Go. All tables (ruangan, inventaris, laporan) will be created automatically.

---

## 💻 Step 3: Running the Application
1. Open Visual Studio Code, click File > Open Folder, and select:
   C:\xampp\htdocs\Project_Alizhar
2. Open your browser and test the modules via these links:
   - Teacher Reporting Form: http://localhost/Project_Alizhar/guru_lapor.php
   - IT Team Dashboard: http://localhost/Project_Alizhar/dashboard_it.php

---

## 👥 Step 4: How to Save & Push Updates to GitHub
Whenever you write new code or make changes, follow these steps to upload it so the rest of the team can see your work:

1. Open your terminal/Git Bash inside the project folder (Project_Alizhar).
2. Check which files have changed:
   git status
3. Stage all your changes:
   git add .
4. Save (commit) your changes with a message describing what you did:
   git commit -m "Update: added new feature or fix"
5. Always pull latest updates from GitHub first (to prevent conflict with teammate changes):
   git pull origin main
6. Push your code to GitHub:
   git push origin main

---
*Developed by the IT Internship Team - Al Izhar Pondok Labu*
