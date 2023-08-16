## ROR Project Primer - ABC Restaurant Employee Portal
# 🚨 Please Fork this repo
### 1. Introduction
Purpose: Create a user-friendly web portal for ABC Restaurant employees to manage orders and access sales reports.

### 2. Project Scope
Employees can:
- Log in using username and password
- Add orders from a predefined menu
- Calculate total order amounts based on item rates and quantity
- View daily sales reports through charts

### 3. Functional Requirements

#### 3.1 Login Page:
- Employees log in with username and password
- Successful login directs employees to the Home Page

#### 3.2 Home Page:
- Displays welcome message and employee's username
- Options:
  - Add an order
  - View Reports
  - Logout

#### 3.3 Add Order Page:
- Date, dropdown for items (Coffee, Samosa, Cake), and quantity fields
- Fetches item rate from the database
- Calculates total amount based on rate and quantity
- On submission, inserts data (employee name, date, item, quantity, amount) into the database

#### 3.4 Reports Page:
- Displays charts for the logged-in employee:
  - Line graph for daily sales
  - Pie chart for products sold by quantity
  - Bar graph for total sales per product
