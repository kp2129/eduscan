# Eduscan

**Eduscan** is a powerful, web-based attendance tracking application that leverages QR code technology to streamline student check-ins for educational institutions. The system generates unique QR codes for each student, ensuring secure and efficient attendance logging.

### Features

- 🟢 **Dynamic QR Codes**: Each student receives a unique QR code that refreshes every two minutes.
- 🟢 **Real-Time Attendance**: Instantly records check-ins and stores them in the database.
- 🟢 **User-Friendly**: Simple, intuitive web interface for seamless use.
- 🟢 **Scalability**: Efficiently handles check-ins for large-scale institutions (1000+ students).
- 🟢 **Security**: Time-limited QR codes ensure only valid and authorized check-ins.

### Technologies

- **Frontend**: React Native (Expo)
- **Backend**: Laravel
- **Database**: MySQL
- **QR Scanning**: Expo Camera
- **Authentication**: OAuth (or your choice of auth provider)

---

## Project Setup

Here’s a breakdown of the key steps involved in building **Eduscan**:

### Checklist

- [x] **Set up React Native app**: Initialize the project using Expo.
- [x] **Add authentication functionality**: Integrate user authentication (e.g., OAuth, Firebase, etc.).
- [x] **Implement camera functionality**: Use `expo-camera` to allow QR code scanning.
- [x] **QR code scanning**: Set up QR code scanning using the camera and validate the scanned data.
- [x] **Generate unique QR codes**: Generate time-limited QR codes for each student, valid for 2 minutes.
- [x] **Validate QR codes on the backend**: Ensure the scanned QR codes are valid by checking against the database.
- [x] **Handle real-time attendance logging**: Store and update attendance records in the database.

---

### How It Works

1. **QR Code Generation**: Each student is assigned a unique, time-sensitive QR code.
2. **Scanning**: Students scan their QR code upon arrival using the mobile interface.
3. **Validation**: The system checks the validity of the QR code and confirms the student’s attendance.
4. **Logging**: Attendance data is automatically recorded in the backend database.

---
