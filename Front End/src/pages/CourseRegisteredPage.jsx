import { useParams, useNavigate } from "react-router-dom";
import Header from "../components/Header";
import Footer from "../components/Footer";
import "../styles/CourseRegistered.css";
import { courses } from "../components/ListCourse.jsx";

const MyCoursePage = () => {
  const { id } = useParams();
  const course = courses.find(c => c.id === parseInt(id));

  if (!course) {
    return <h1>Cours non trouvé</h1>;
  }

  return (
    <>
      <Header />
      <div className="course-hero">
        <h1>{course.title}</h1>
        <p>{course.description}</p>
      </div>

      <div className="course-layout">
        <aside className="course-sidebar">
          <button className="active">Course Overview</button>
          <button>Course Chapters</button>
          <button>Materials</button>
          <button>Progress Tracking</button>
        </aside>

        <main className="course-content">
          <div className="course-detail-card">
            <h2>Course Overview</h2>

            <h4>Description</h4>
            <p>{course.detailedDescription}</p>

            <h4>Learning Objectives</h4>
            <ul>
              {course.learningOutcomes?.map((item, index) => (
                <li key={index}>{item}</li>
              ))}
            </ul>
          </div>
        </main>
      </div>

      <Footer />
    </>
  );
};

export default MyCoursePage;
