Federal Parliament of Canada Legislative Bill Management System

#Project Overview
The entire legislative bill lifecycle, from writing to final approval, is managed by this software system, which supports the Canadian Federal Parliament's legislative process. It stores data in JSON files using the Repository pattern and SOLID principles, and it manages state using PHP sessions and cookies.

#System Architecture
The system follows a multi-tier architecture using the MVC (Model-View-Controller) pattern:
Model: Represents the data and business logic
View: Handles the presentation layer
Controller: Manages the flow between Model and View

#Key Components:
User Authentication and Role Management
Bill Management System
Voting System

#Authentication and Session Management
Uses PHP sessions for maintaining user login state
Role-based access control (Member of Parliament, Reviewer, Administrator)

# Key Functionalities
1.User Management
Registration
Login/Logout
Role assignment

2.Bill Management
Create new bills
View and edit bills
Version tracking
Amendment suggestions
Approval workflow

3.Voting System
Initiate voting sessions
Cast votes
Record and calculate results

4.Reporting
User dashboards

5.Security Considerations
Password hashing
Input validation and sanitization
Secure session

#Project Setup
1.Clone the repository under XAMPP/htdocs folder using git clone https://github.com/aditya-42/bill-voting-system.git 
2.Start the XAMPP server and Php My Admin for database 
3.Open http://localhost/bill-voting-system/public/ 



Dashboard
 ![image](https://github.com/user-attachments/assets/0d1c6edd-7ba8-419f-906f-e233e530d14d)

Register Page
 ![image](https://github.com/user-attachments/assets/0ff841f1-f572-481f-90bf-ce4bdd51b92c)

Login Page
![image](https://github.com/user-attachments/assets/dbc9942a-ff33-4f5f-a3b1-f4cead9ca695)


Member of Parliament Dashboard
 ![image](https://github.com/user-attachments/assets/90893fc9-427b-4fda-b0f9-c78b2d49f78c)




Create New BIll
 ![image](https://github.com/user-attachments/assets/c8e58df2-0beb-429c-abd4-dd9561388c30)


View all Bills 
 ![image](https://github.com/user-attachments/assets/766d3715-c8f9-49fe-a1ff-6ae11cc4eec4)

Edit Bill
![image](https://github.com/user-attachments/assets/5aa04002-3148-4a6b-a7ff-b7705cd2cf26)

 
Reviewer Dashboard
 ![image](https://github.com/user-attachments/assets/79c0c44c-1380-468e-9e79-faabce65e309)

Ammendment
![image](https://github.com/user-attachments/assets/7e0abf41-2099-4023-b44f-d5f405c9dbb5)

 
Admin dashboard
 ![image](https://github.com/user-attachments/assets/b44d5926-de42-4337-bef1-40ca5bc2c3c7)

Vote
![image](https://github.com/user-attachments/assets/7371a39c-513f-44fd-a80e-d10132900457)


 

 




