from django.db import models

class Course(models.Model):
    course_id = models.AutoField(primary_key=True)
    course_name = models.CharField(max_length=100)
    duration = models.CharField(max_length=50)
    description = models.TextField(blank=True, null=True)

    class Meta:
        db_table = "courses"

    def __str__(self):
        return self.course_name
  