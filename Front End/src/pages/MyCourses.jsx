import { useState, useContext, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import Header from "../components/Header";
import Footer from "../components/Footer";
import CourseCard from "../components/CourseCard";
import "../styles/ExploreCourses.css";
import { courses } from "../components/ListCourse";
import { AuthContext } from "../context/AuthContext";

// List of the courses the user is registered to
export let myCoursesIds = []; 

const ITEMS_PER_PAGE = 9;

const MyCourses = () => {
  const [currentPage, setCurrentPage] = useState(1);
  const navigate = useNavigate();
  const { user, login } = useContext(AuthContext);

    useEffect(() => {
    if (!user) {
      myCoursesIds = []; 
    }
  }, [user]);
  
  const myCoursesList = courses.filter(course =>
    myCoursesIds.includes(course.id)
  );

  const noCourses = myCoursesList.length === 0;

  const totalPages = Math.ceil(myCoursesList.length / ITEMS_PER_PAGE);
  const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
  const currentCourses = myCoursesList.slice(startIndex, startIndex + ITEMS_PER_PAGE);

  const goToPage = (page) => {
    if (page >= 1 && page <= totalPages) setCurrentPage(page);
    window.scrollTo({ top: 0, behavior: "smooth" });
  };

  return (
    <>
      <Header />

      <div className="explore-page">
        <div className="explore-header">
          <h1 className="explore-title">My Courses</h1>

          <button
            className="add-course-page-button"
            onClick={() => navigate("/explore-courses")}
          >
            Register New Course
          </button>
        </div>

        {noCourses ? (
          <div className="no-courses-message">
            <p>You are not enrolled in any course yet.</p>
            <p>Please browse our catalog to get started.</p>
          </div>
        ) : (
          <>
            <div className="explore-grid">
              {currentCourses.map((course) => (
                <CourseCard
                  key={course.id}
                  course={course}
                  onClick={() => navigate(`/my-course/${course.id}`)}
                />
              ))}
            </div>

            <div className="pagination">
              <button
                className="page-arrow"
                onClick={() => goToPage(currentPage - 1)}
                disabled={currentPage === 1}
              >
                ‹
              </button>

              {[...Array(totalPages)].map((_, i) => (
                <button
                  key={i}
                  className={`page-number ${
                    currentPage === i + 1 ? "active" : ""
                  }`}
                  onClick={() => goToPage(i + 1)}
                >
                  {i + 1}
                </button>
              ))}

              <button
                className="page-arrow"
                onClick={() => goToPage(currentPage + 1)}
                disabled={currentPage === totalPages}
              >
                ›
              </button>
            </div>
          </>
        )}
      </div>

      <Footer />
    </>
  );
};

export default MyCourses;
