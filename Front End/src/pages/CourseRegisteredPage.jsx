import { useParams, useNavigate } from "react-router-dom";
import Header from "../components/Header";
import Footer from "../components/Footer";
import "../styles/CoursePage.css";
import { courses } from "../components/ListCourse.jsx";

const MyCoursePage = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const course = courses.find(c => c.id === parseInt(id));

  const progress = 40; // exemple fictif : 40% complété

  if (!course) {
    return (
      <>
        <Header />
        <div className="course-detail">
          <h1>Cours non trouvé</h1>
          <button onClick={() => navigate("/my-courses")}>Back to My Courses</button>
        </div>
        <Footer />
      </>
    );
  }

  return (
    <>
      <Header />
      <div className="course-detail">
        <button className="back-button" onClick={() => navigate("/my-courses")}>
          ← Back to My Courses
        </button>

        <h1>{course.title}</h1>

        <h2>Course Details</h2>
        <p>{course.detailedDescription}</p>

        <h2>Learning Outcomes</h2>
        <ul>
          {course.learningOutcomes && course.learningOutcomes.map((item, index) => (
            <li key={index}>{item}</li>
          ))}
        </ul>

        <h2>Your Progress</h2>
        <div className="progress-bar-container">
          <div
            className="progress-bar-fill"
            style={{ width: `${progress}%` }}
          ></div>
        </div>

        <button
          className="continue-button"
          onClick={() => console.log(`Continue course: ${course.title}`)}
        >
          Continue Course
        </button>
      </div>
      <Footer />
    </>
  );
};

export default MyCoursePage;
