
const slotStartHour = document.getElementById('agenda_slotsStart_hour');
const slotStartMinute = document.getElementById('agenda_slotsStart_minute');
const slotEndHour = document.getElementById('agenda_slotsEnd_hour');
const slotEndMinute = document.getElementById('agenda_slotsEnd_minute');
const slotDuration = document.getElementById('agenda_slotsDuration');
const generateSlots = document.getElementById('generate-slots');

if (slotStartHour && slotStartMinute && slotEndHour && slotEndMinute && slotDuration && generateSlots) {
    generateSlots.addEventListener('click', function (e) {
        let slots;
        e.preventDefault();
        const startHour = slotStartHour.value;
        const startMinute = slotStartMinute.value;
        const endHour = slotEndHour.value;
        const endMinute = slotEndMinute.value;
        const duration = slotDuration.value;

        slots = createSlots(startHour, startMinute, endHour, endMinute, duration);

        const slotsContainer = document.getElementById('slots-list');
        slotsContainer.innerHTML = '';

        slots.forEach(function (slot, index) {
            const div = document.createElement('div');
            div.classList.add('form-group');
            div.innerHTML = `
                <li>
                    <label for="agenda_slots_${slot}" class="col-form-label" > Créneau ${slot} </label>
                    <input type="checkbox" checked="true" id="agenda_slots_${index}_start" name="agenda_slots" value="${slot}" class="form-control slot" />
                </li>
            `;
            slotsContainer.appendChild(div);
        });

        handleSlotInput();

    });
}




function handleSlotInput()
{
    const allSlotsGenerate = document.querySelectorAll('.slot');
    addSlot()

    allSlotsGenerate.forEach(function (slot) {
        slot.addEventListener('input', function (e) {
            addSlot();
        });
    });


}

function addSlot()
{
    const slots = document.querySelectorAll('input[name="agenda_slots"]:checked');
    const slotsHiddenInput = document.getElementById('agenda_slots');
    const slotsArray = [];

    slots.forEach(function (slot) {
        slotsArray.push(slot.value);
    });

    slotsHiddenInput.value = slotsArray
}

function createSlots(startHour, startMinute, endHour, endMinute, slotDuration)
{
    // convert start and end time to minutes
    const startTime = parseInt(startHour) * 60 + parseInt(startMinute);
    const endTime = parseInt(endHour) * 60 + parseInt(endMinute);
    const duration = parseInt(slotDuration);

    // initialize array of time slots
    const timeSlots = [];

    // loop through time slots
    for (let i = startTime; i <= endTime; i += duration) {
        // calculate slot start time and end time
        const slotStartHour = Math.floor(i / 60);
        const slotStartMinute = i % 60;
        const slotEndHour = Math.floor((i + duration) / 60);
        const slotEndMinute = (i + duration) % 60;

        // format slot start and end time
        const slotStartTime = `${slotStartHour.toString().padStart(2, '0')}:${slotStartMinute.toString().padStart(2, '0')}`;
        //const slotEndTime = `${slotEndHour.toString().padStart(2, '0')}:${slotEndMinute.toString().padStart(2, '0')}`;

        // add slot to time slots array
        timeSlots.push(slotStartTime);
    }

    return timeSlots;
}

