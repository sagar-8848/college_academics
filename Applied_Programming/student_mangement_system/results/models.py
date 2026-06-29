from django.db import models
from students.models import Student
from exams.models import Exam
from subjects.models import Subject


class Result(models.Model):
    result_id = models.AutoField(primary_key=True)

    student = models.ForeignKey(
        Student,
        on_delete=models.CASCADE,
        db_column="student_id"
    )

    exam = models.ForeignKey(
        Exam,
        on_delete=models.CASCADE,
        db_column="exam_id"
    )

    subject = models.ForeignKey(
        Subject,
        on_delete=models.CASCADE,
        blank=True,
        null=True,
        db_column="subject_id"
    )

    marks_obtained = models.IntegerField()
    grade = models.CharField(max_length=5, blank=True, null=True)
    created_at = models.DateTimeField(auto_now_add=True)

    class Meta:
        db_table = "results"
        unique_together = ("student", "exam", "subject")

    def calculate_grade(self):
        if self.exam and self.exam.total_marks:
            percentage = (self.marks_obtained / self.exam.total_marks) * 100
        else:
            percentage = self.marks_obtained

        if percentage >= 90:
            return "A+"
        if percentage >= 80:
            return "A"
        if percentage >= 70:
            return "B"
        if percentage >= 60:
            return "C"
        if percentage >= 50:
            return "D"
        return "F"

    def save(self, *args, **kwargs):
        self.grade = self.calculate_grade()
        if self.exam:
            self.subject = self.exam.subject
        super().save(*args, **kwargs)

    def __str__(self):
        return f"{self.student} - {self.exam}"