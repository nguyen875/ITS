import { useParams, useNavigate } from 'react-router-dom';
import Header from "../components/Header";
import Footer from "../components/Footer";
import "../styles/CoursePage.css";
import { courses } from "../components/ListCourse.jsx";
import { myCoursesIds } from "./MyCourses.jsx";

const CoursesPage = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const course = courses.find(c => c.id === parseInt(id));

  const handleRegister = () => {
    if (!course) return;
    if (myCoursesIds.includes(course.id)) {
      alert("You are already enrolled in this course.");
      return;
    }
    myCoursesIds.push(course.id);
    alert("The course has been successfully added to My Courses!");
  };

  if (!course) {
    return (
      <>
        <Header />
        <div className="course-detail">
          <h1>Course not found</h1>
          <button className="error-button" onClick={() => navigate('/explore-courses')}>
            Back To Explore
          </button>
        </div>
        <Footer />
      </>
    );
  }

  return (
    <>
      <Header />
      <div className="course-detail">
        <button className="back-button" onClick={() => navigate('/explore-courses')}>
          ← Back To Explore
        </button>

        <h1 style={{ textAlign: 'center' }}>{course.title}</h1>

        <h2>Course Details</h2>
        <p>{course.detailedDescription}</p>

        <h2>Learning Outcomes</h2>
        <ul>
          {course.learningOutcomes?.map((outcome, index) => (
            <li key={index}>{outcome}</li>
          ))}
        </ul>

        <button className="register-button" onClick={handleRegister}>
          Register to the Course
        </button>
      </div>
      <Footer />
    </>
  );
};

export default CoursesPage;
