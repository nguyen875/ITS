import "../styles/CourseCard.css";

const CourseCard = ({ course }) => {
  return (
    <div className="course-card">
      <div className="course-title-rectangle">{course.title}</div>
      <div className="course-description">{course.description}</div>
    </div>
  );
};

export default CourseCard;
