# This is a temporary doc for backend API
## Authorization Middleware
- To authorize a user’s action based on their JWT token, call: $authorization_middleware->authorize_request('<action_name>');
- For backend team: Add new action names to the role‑based permissions list. Each role is the array key, and its value is an array of allowed actions.
## POST method
### http://localhost/its/student_register
- Can be use for student account only, will immediately create active student account
- Input:
    - Email:  string, valid email format
    - Password: string, 8-100 characters, at least 1 uppercase, lowercase, @$!%*?& and 0-9 number
- Output:
    - 200: successfully registered
    - 400 or 500: error
### http://localhost/its/teacher_register
- Can be use for teacher account only, will immediately create inactive teacher account. Need admin to activate teacher account
- Input:
    - Email:  string, valid email format
    - Password: string, 8-100 characters, at least 1 uppercase, lowercase, @$!%*?& and 0-9 number
- Output:
    - 200: successfully registered
    - 400 or 500: error
### http://localhost/its/user_login
- Can be use for any role to login to the system
- Input:
    - Email:  string, valid email format
    - Password: string, 8-100 characters, at least 1 uppercase, lowercase, @$!%*?& and 0-9 number
- Output:
    - 200: successfully registered
        - Include JWT token
    - 400 or 500: error

### http://localhost/its/admin_create
- Can be use by admins to create a new user (Student, Teacher, or Admin)
- Input:
    - Email: string, valid email format
    - Password: string, 8-100 characters, at least 1 uppercase, 1 lowercase, 1 special char from @$!%*?&, and 1 digit
    - Name: string
    - Role: string, one of Student, Teacher, Admin
- Output:
    - 200: successfully created
    - Body: {"message":"User created successfully"}
    - 400 or 500: error

### http://localhost/its/admin_edit
Can be use by admins to edit an existing user
- Input:
    - user_id: integer (required)
    - Email: string, valid email format (optional)
    - Password: string, 8-100 characters, at least 1 uppercase, 1 lowercase, 1 special char from @$!%*?&, and 1 digit (optional)
    - Name: string (optional)
    - Role: string, one of Student, Teacher, Admin (optional)
- Output:
    - 200: successfully updated
    - Body: {"message":"User updated successfully"}
    - 400 or 500: error

### http://localhost/its/admin_delete
Can be use by admins to delete a user by id
- Input:
    - user_id: integer (required)
- Output:
    - 200: successfully deleted
    - Body: {"message":"User deleted successfully"}
    - 400 or 500: error