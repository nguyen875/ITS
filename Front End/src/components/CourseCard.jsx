import { useNavigate } from "react-router-dom";
import "../styles/CourseCard.css";

const CourseCard = ({ course, onClick }) => {
  return (
    <div className="course-card">
      <div 
        className="course-title-rectangle" 
        onClick={onClick} // utilise la prop onClick
      >
        {course.title}
      </div>
      <div className="course-description">{course.description}</div>
    </div>
  );
};

export default CourseCard;
