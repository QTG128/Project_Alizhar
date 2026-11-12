# IT Inventory & Damage Reporting Module - Al Izhar Pondok Labu

## 📌 Project Description (Internship Project)
This project is the development of an additional feature/module (add-on) designed to be integrated into Al Izhar Pondok Labu's in-house system. 

The main goal of this module is to accelerate the follow-up process for replacing IT equipment. Teachers can easily report equipment damage (e.g., monitors, projectors) specifically based on their classroom (e.g., SMP 204). The notification will instantly appear on the IT Team Dashboard along with recommendations for replacement items that are *ready* in the inventory.

## 🚀 Key Features
- **Room-Based Reporting:** Displays a list of equipment available specifically in the room where the teacher is reporting from.
- **IT Dashboard (Instant Notifications):** The IT team can view incoming damage tickets in real-time.
- **Replacement Stock Search:** The system automatically searches the inventory database for available replacement equipment.

## 🛠️ Tech Stack
- **Backend:** PHP Native
- **Database:** MySQL
- **Local Server:** XAMPP / Laragon

## 💻 How to Run the Project (For Team Members)
1. **Clone Repo:** Open your terminal, navigate to the `htdocs` folder (if using XAMPP), and run:
   `git clone [LINK_GITHUB_REPO_INI]`
2. **Database Setup:**
   - Start Apache & MySQL from your XAMPP Control Panel.
   - Open `http://localhost/phpmyadmin` in your browser.
   - Create a new database named `db_alizhar`.
   - **Import** the `db_alizhar.sql` file located in this project directory.
3. **Run the Application:** 
   - Open your browser and access: `http://localhost/nama-folder-repo/`
