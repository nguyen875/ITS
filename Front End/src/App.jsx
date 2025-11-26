import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Homepage from "./pages/Homepage";
import Login from "./pages/Login";
import SignUp from "./pages/SignUp";
import ForgotPassword from "./pages/ForgotPassword";
import ExploreCourses from "./pages/ExploreCourses";
import MyCourses from "./pages/MyCourses";
import { AuthProvider } from "./context/AuthContext";
import CoursesPage from "./pages/CoursePage";
import CoursesDetailPage from "./pages/CourseRegisteredPage";


const App = () => {
  return (
    <AuthProvider>
      <Router>
        <Routes>
          <Route path="/" element={<Homepage />} />
          <Route path="/login" element={<Login />} />
          <Route path="/sign-up" element={<SignUp />} />
          <Route path="/forgot-password" element={<ForgotPassword />} />
          <Route path="/explore-courses" element={<ExploreCourses />} />
          <Route path="/my-courses" element={<MyCourses />} />
          <Route path="/course/:id" element={<CoursesPage />} />
          <Route path="/my-course/:id" element={<CoursesDetailPage />} />
        </Routes>
      </Router>
    </AuthProvider>
  );
};

export default App;
