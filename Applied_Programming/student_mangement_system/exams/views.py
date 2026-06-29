from django.contrib import messages
from django.core.paginator import Paginator
from django.db.models import Q
from django.shortcuts import get_object_or_404, redirect, render

from .forms import ExamForm
from .models import Exam
from django.contrib.auth.decorators import login_required
from django.contrib.auth.decorators import permission_required

@login_required
@permission_required("exams.view_exam")
def exam_list(request):
	search_query = request.GET.get("search", "")
	exams = Exam.objects.select_related("subject").all()

	if search_query:
		exams = exams.filter(
			Q(exam_type__icontains=search_query)
			| Q(subject__subject_name__icontains=search_query)
			| Q(subject__subject_code__icontains=search_query)
		).distinct()

	paginator = Paginator(exams, 10)
	page_number = request.GET.get("page")
	page_obj = paginator.get_page(page_number)

	return render(
		request,
		"exams/exam_list.html",
		{
			"exams": page_obj,
			"page_obj": page_obj,
			"search_query": search_query,
		},
	)

@login_required
@permission_required("exams.add_exam")
def add_exam(request):
	form = ExamForm(request.POST or None)

	if request.method == "POST" and form.is_valid():
		form.save()
		messages.success(request, "Exam added successfully!")
		return redirect("exam_list")

	return render(
		request,
		"shared/form.html",
		{
			"form": form,
			"form_title": "Add Exam",
			"submit_label": "Save Exam",
			"cancel_url": "/exams/",
		},
	)

@login_required
@permission_required("exams.change_exam")
def edit_exam(request, exam_id):
	exam = get_object_or_404(Exam, exam_id=exam_id)
	form = ExamForm(request.POST or None, instance=exam)

	if request.method == "POST" and form.is_valid():
		form.save()
		messages.success(request, "Exam updated successfully!")
		return redirect("exam_list")

	return render(
		request,
		"shared/form.html",
		{
			"form": form,
			"form_title": "Edit Exam",
			"submit_label": "Update Exam",
			"cancel_url": "/exams/",
		},
	)

@login_required
@permission_required("exams.delete_exam")
def delete_exam(request, exam_id):
	exam = get_object_or_404(Exam, exam_id=exam_id)

	if request.method == "POST":
		exam.delete()
		messages.success(request, "Exam deleted successfully!")
		return redirect("exam_list")

	return render(
		request,
		"shared/confirm_delete.html",
		{
			"title": "Delete Exam",
			"message": f"Are you sure you want to delete {exam.exam_type} for {exam.subject}?",
			"confirm_label": "Delete Exam",
			"cancel_url": "/exams/",
		},
	)
