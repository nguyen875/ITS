import { useState } from "react";
import { useNavigate } from "react-router-dom";
import Header from "../components/Header";
import Footer from "../components/Footer";
import CourseCard from "../components/CourseCard";
import "../styles/ExploreCourses.css";

const myCourses = [
  { title: "React for Beginners", description: "Learn React step by step", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
  { title: "Advanced Python", description: "Deep dive into Python", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
  { title: "UI/UX Basics", description: "Design better UI", image: "https://img-c.udemycdn.com/course/480x270/4782160_dfdf.jpg" },
];

const ITEMS_PER_PAGE = 9;

const MyCourses = () => {
  const [currentPage, setCurrentPage] = useState(1);
  const navigate = useNavigate();

  const totalPages = Math.ceil(myCourses.length / ITEMS_PER_PAGE);
  const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
  const currentCourses = myCourses.slice(startIndex, startIndex + ITEMS_PER_PAGE);

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

        <div className="explore-grid">
          {currentCourses.map((course, idx) => (
            <CourseCard key={idx} course={course} />
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
              className={`page-number ${currentPage === i + 1 ? "active" : ""}`}
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
      </div>

      <Footer />
    </>
  );
};

export default MyCourses;
