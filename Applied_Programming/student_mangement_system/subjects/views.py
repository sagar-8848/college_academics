from django.contrib import messages
from django.core.paginator import Paginator
from django.db.models import Q
from django.shortcuts import get_object_or_404, redirect, render

from .forms import SubjectForm
from .models import Subject
from django.contrib.auth.decorators import login_required
from accounts.decorators import permission_required


@login_required
@permission_required("subjects.view_subject")
def subject_list(request):
	search_query = request.GET.get("search", "")
	subjects = Subject.objects.select_related("course", "faculty").all()

	if search_query:
		subjects = subjects.filter(
			Q(subject_name__icontains=search_query)
			| Q(subject_code__icontains=search_query)
			| Q(course__course_name__icontains=search_query)
			| Q(faculty__full_name__icontains=search_query)
		).distinct()

	paginator = Paginator(subjects, 10)
	page_number = request.GET.get("page")
	page_obj = paginator.get_page(page_number)

	return render(
		request,
		"subjects/subject_list.html",
		{
			"subjects": page_obj,
			"page_obj": page_obj,
			"search_query": search_query,
		},
	)

@login_required
@permission_required("subjects.add_subject")
def add_subject(request):
	form = SubjectForm(request.POST or None)

	if request.method == "POST" and form.is_valid():
		form.save()
		messages.success(request, "Subject added successfully!")
		return redirect("subject_list")

	return render(
		request,
		"shared/form.html",
		{
			"form": form,
			"form_title": "Add Subject",
			"submit_label": "Save Subject",
			"cancel_url": "/subjects/",
		},
	)

@login_required
@permission_required("subjects.change_subject")
def edit_subject(request, subject_id):
	subject = get_object_or_404(Subject, subject_id=subject_id)
	form = SubjectForm(request.POST or None, instance=subject)

	if request.method == "POST" and form.is_valid():
		form.save()
		messages.success(request, "Subject updated successfully!")
		return redirect("subject_list")

	return render(
		request,
		"shared/form.html",
		{
			"form": form,
			"form_title": "Edit Subject",
			"submit_label": "Update Subject",
			"cancel_url": "/subjects/",
		},
	)

@login_required
@permission_required("subjects.delete_subject")
def delete_subject(request, subject_id):
	subject = get_object_or_404(Subject, subject_id=subject_id)

	if request.method == "POST":
		subject.delete()
		messages.success(request, "Subject deleted successfully!")
		return redirect("subject_list")

	return render(
		request,
		"shared/confirm_delete.html",
		{
			"title": "Delete Subject",
			"message": f"Are you sure you want to delete {subject.subject_name}?",
			"confirm_label": "Delete Subject",
			"cancel_url": "/subjects/",
		},
	)
