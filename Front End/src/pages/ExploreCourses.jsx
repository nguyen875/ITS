import { useState } from "react";
import { useNavigate } from "react-router-dom";
import Header from "../components/Header";
import Footer from "../components/Footer";
import CourseCard from "../components/CourseCard";
import "../styles/ExploreCourses.css";
import { courses } from "../components/ListCourse.jsx";

const ITEMS_PER_PAGE = 9;

const ExploreCourses = () => {
  const [currentPage, setCurrentPage] = useState(1);
  const navigate = useNavigate();
  const totalPages = Math.ceil(courses.length / ITEMS_PER_PAGE);

  const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
  const currentCourses = courses.slice(startIndex, startIndex + ITEMS_PER_PAGE);

  const goToPage = (page) => {
    if (page >= 1 && page <= totalPages) setCurrentPage(page);
    window.scrollTo({ top: 0, behavior: "smooth" });
  };

  return (
    <>
      <Header />

      <div className="explore-page">
        <h1 className="explore-title">Explore Courses</h1>

        <div className="explore-grid">
          {currentCourses.map((course) => (
            <CourseCard
              key={course.id}
              course={course}
              onClick={() => navigate(`/course/${course.id}`)} // ici on redirige vers page register
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

export default ExploreCourses;
