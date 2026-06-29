from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ("faculties", "0001_initial"),
        ("subjects", "0001_initial"),
    ]

    operations = [
        migrations.AddField(
            model_name="subject",
            name="subject_code",
            field=models.CharField(blank=True, max_length=20, null=True, unique=True),
        ),
        migrations.AddField(
            model_name="subject",
            name="faculty",
            field=models.ForeignKey(
                blank=True,
                db_column="faculty_id",
                null=True,
                on_delete=django.db.models.deletion.SET_NULL,
                related_name="subjects",
                to="faculties.faculty",
            ),
        ),
    ]