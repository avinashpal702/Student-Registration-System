function createTextElement(tag, className, text) {
    const element = document.createElement(tag);
    element.className = className;
    element.textContent = text;
    return element;
}

function createCourseCard(course, index, enrollmentPage, authenticated) {
    const column = document.createElement('div');
    column.className = 'col-md-6 col-lg-4';

    const card = document.createElement('article');
    card.className = 'course-card';

    const top = document.createElement('div');
    top.className = 'course-card-top';
    top.append(
        createTextElement('span', 'course-symbol', ['✳', '⌘', '↗'][index % 3]),
        createTextElement('span', 'course-number', `COURSE ${String(index + 1).padStart(2, '0')}`)
    );

    const title = createTextElement('h3', '', course.name);
    const description = createTextElement('p', '', course.description || 'A new opportunity to learn and grow.');
    const footer = document.createElement('div');
    footer.className = 'course-card-footer';
    footer.append(createTextElement('span', 'spots-label', `${course.available_places} ${course.available_places === 1 ? 'place' : 'places'} available`));

    if (enrollmentPage) {
        const form = document.createElement('form');
        form.method = 'post';
        const courseId = document.createElement('input');
        courseId.type = 'hidden';
        courseId.name = 'course_id';
        courseId.value = course.id;
        const button = document.createElement('button');
        button.type = 'submit';
        button.className = 'course-action';
        button.textContent = 'Enroll →';
        button.disabled = Number(course.available_places) < 1;
        form.append(courseId, button);
        footer.append(form);
    } else {
        const action = document.createElement('a');
        action.className = 'course-action';
        action.href = authenticated ? 'enroll.php' : 'register.php';
        action.textContent = authenticated ? 'View course →' : 'Get started →';
        footer.append(action);
    }

    card.append(top, title, description, footer);
    column.append(card);
    return column;
}

async function loadCourses() {
    const container = document.getElementById('course-list');
    if (!container) return;

    try {
        const response = await fetch('courses.php');
        if (!response.ok) throw new Error(`Course request failed with HTTP ${response.status}.`);

        const courses = await response.json();
        if (!Array.isArray(courses)) throw new Error('The course list response was invalid.');

        container.replaceChildren();
        if (courses.length === 0) {
            container.append(createTextElement('p', 'course-empty col-12', 'There are no courses available yet. Check back soon.'));
            return;
        }

        const enrollmentPage = document.body.dataset.page === 'enroll';
        const authenticated = document.body.dataset.authenticated === 'true';
        courses.forEach((course, index) => {
            container.append(createCourseCard(course, index, enrollmentPage, authenticated));
        });
    } catch (error) {
        console.error(error);
        container.replaceChildren(createTextElement('p', 'course-error col-12', 'Courses could not be loaded right now. Please refresh the page to try again.'));
    }
}

document.addEventListener('DOMContentLoaded', loadCourses);