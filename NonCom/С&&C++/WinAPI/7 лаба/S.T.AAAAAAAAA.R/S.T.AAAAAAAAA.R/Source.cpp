// --- Обязательный включаемый файл
#include <windows.h>
#include <iostream>
#include <time.h>

using namespace std;
#define PI 3.14156

struct STAR
{
	unsigned N; // количество фрагментов (вид изображения)
	int x, y; // координаты центра звезды (местоположение)
	unsigned r; 		// радиус звезды (размер)
	COLORREF color; 	// цвет линии (цвет изображения)
};


void random(HWND hwnd,unsigned& N,int& x,int &y,unsigned &r,COLORREF &color)
{
	RECT rect = { 0, 0, 0, 0 };
	GetClientRect(hwnd, &rect);
	srand(time(NULL));
	N = rand() % 25 + 5;
	r = rand() % 220 + 20;
	/*int width=GetSystemMetrics(SM_CXSCREEN);
	int heigth = GetSystemMetrics(SM_CYSCREEN);*/
	int width = rect.right;
	int heigth = rect.bottom;
	x = rand() % (width - r) + r;
	y = rand() % (heigth - r) + r;
	color= RGB(rand() % 255, rand() % 255, rand() % 255);

}

void ugol(HDC hDC, int x1, int y1, int x2, int y2, int x3, int y3, int n);
// рабочая функция
void star(HDC hDC, struct STAR str)
{
	int rc = str.r / 3; // радиус центра звезды
	double a1, a2, a3, d = 2. * PI / (str.N * 2);

	// создание объектов GDI (функция CreatePen)… создание сплошного пера цвета str.color толщиной 3 пикселя

	HPEN hpen;
	HGDIOBJ hpenOld;
	hpen = CreatePen(PS_SOLID, 3, str.color);

	// установка атрибутов контекста отображения (функция SelectObject)… установка созданного пера в контекст hDC и сохранение "старого" пера
	hpenOld = SelectObject(hDC,hpen);

		for (int i = 1; i <= str.N; i++)
			// рисуем очередной фрагмент звезды ( 1<=i<=N)
		{
			// определение значений углов
			a1 = 2 * PI * (i - 1) / str.N; a2 = a1 + d; a3 = a1 - d;

			// вывод угла, заштрихованного отрезками
			ugol(hDC, str.x, str.y, str.x + str.r * sin(a1),
				str.y + str.r * cos(a1), str.x + rc * sin(a2), str.y + rc * cos(a2), 25);
			ugol(hDC, str.x, str.y, str.x + str.r * sin(a1), str.y + str.r * cos(a1),
				str.x + rc * sin(a3), str.y + rc * cos(a3), 25);
		}

	// восстановление атрибутов контекста отображения… установка "старого" пера в контекст hDC
		SelectObject(hDC, hpenOld);
		
		// удаление созданых объектов GDI… удаление созданного пера
		DeleteObject(hpen);
}

// вывод угла, заштрихованного отрезками
void ugol(HDC hDC, int x1, int y1, int x2, int y2, int x3, int y3, int n)
{
	int n1 = n + 1; double a; int xx1, yy1, xx2, yy2;
	for (int i = 1; i <= n1; i++)
	{
		a = (i - 1.) / n;
		xx1 = x1 + (x2 - x1) * a; yy1 = y1 + (y2 - y1) * a;
		xx2 = x2 + (x3 - x2) * a; yy2 = y2 + (y3 - y2) * a;

		// вывод очередной линии от (xx1,yy1) до (xx2,yy2)
		// (функции MoveToEx и LineTo)… передвинуть текущую позицию пера в точку с координатами(xx1, yy1)… провести линию от текущей позиции пера до точки(xx2, yy2)
		MoveToEx(hDC, (int)xx1, (int)yy1 - 10, (LPPOINT)NULL);
		LineTo(hDC, (int)xx2, (int)yy2 + 10);
	}
}



// --- Описание функции главного окна
LRESULT CALLBACK WndProc(HWND hWnd, UINT msg, WPARAM wParam, LPARAM lParam);

// --- Глобальные переменные
HINSTANCE hInst; 		// Дескриптор экземпляра приложения
char ClassName[] = "Window"; 		// Название класса окна
char AppTitle[] = "S.T.AAAAAAAAA.R"; 	// Заголовок главного окна

HWND hTextBox;


// --- Функция WinMain
int WINAPI WinMain(HINSTANCE hInstance,
	// Дескриптор экземпляра приложения
	HINSTANCE hPrevInstance, // В Win32 всегда равен NULL
	LPSTR lpCmdLine,
	// Указатель на командную строку. Он // позволяет
	// приложению получать данные из командной строки.
	int nCmdShow
	// Определяет, как приложение первоначально 
	// отображается на дисплее: пиктограммой
	// (nCmdShow = SW_SHOWMINNOACTIVE) 
	// или в виде открытого окна 					//(nCmdShow = SW_SHOWNORMAL).
)
{
	WNDCLASS wc; 	// Структура для информации о классе окна
	HWND hWnd; 	// Дескриптор главного окна приложения
	HBRUSH greyBrush = CreateSolidBrush(RGB(220, 220, 220));
	MSG msg; 	// Структура для хранения сообщения
// Сохраняем дескриптор экземпляра приложения в глобальной
// переменной, чтобы при необходимости воспользоваться им в
// функции окна.
	hInst = hInstance;


	// --- Проверяем, было ли приложение запущено ранее.
	// Воспользуемся функцией FindWindow, которая позволяет
	// найти окно верхнего 
	// уровня по имени класса или по заголовку окна:
	// HWND FindWindow(LPCTSTR lpClassName,
	// LPCTSTRlpWindowName);
	// Через параметр lpClassName передается указатель на
	// текстовую строку, в которую необходимо записать имя
	// класса искомого окна. На базе одного и того же класса 
	// можно создать несколько окон. Если необходимо найти 
	// окно с заданным заголовком, то имя заголовка следует
	// передать через параметр lpWindowName. Если же подойдет 
	// любое окно, то параметр lpWindowName может иметь
	// значение NULL.
	if ((hWnd = FindWindow(ClassName, NULL)) != NULL)
	{
		// Пользователь может не помнить, какие приложения уже
		// запущены, а какие нет. Когда он запускает приложение, 
		// то ожидает, что на экране появится его главное окно.
		// Поэтому, если приложение было запущено ранее,
		// целесообразно активизировать и выдвинуть на передний
		// план его главное окно. Это именно то, к чему приготовился
		// пользователь.
		if (IsIconic(hWnd)) ShowWindow(hWnd, SW_RESTORE);
		SetForegroundWindow(hWnd);

		// Найдена работающая копия - работа новой копии
		// прекращается.
		return FALSE;
	}

	// --- Работающая копия не найдена - функция WinMain
	// приступает к инициализации. Заполнение структуры
	// WNDCLASS для регистрации класса окна.
	memset(&wc, 0, sizeof(wc));
	wc.lpszClassName = ClassName;		// Имя класса окон
	wc.lpfnWndProc = (WNDPROC)WndProc;
	// Адрес оконной функции
	wc.style = CS_HREDRAW | CS_VREDRAW;	// Стиль класса 
	wc.hInstance = hInstance;		// Экземпляр приложения
	wc.hIcon = LoadIcon(NULL, IDI_APPLICATION);
	// Пиктограмма для окон
	wc.hCursor = LoadCursor(NULL, IDC_ARROW);
	// Курсор мыши для окон
	wc.hbrBackground = (HBRUSH)GetStockObject(WHITE_BRUSH);
	// Кисть для окон
	wc.lpszMenuName = NULL;			// Ресурс меню окон
	wc.cbClsExtra = 0;			// Дополнительная память
	wc.cbWndExtra = 0;			// Дополнительная память
	//wc.hbrBackground = greyBrush;
	
	// Pегистрация класса окна.
	RegisterClass(&wc);

	// Создаем главное окно приложения.
	hWnd = CreateWindow(
		ClassName, 			// Имя класса окон
		AppTitle,			// Заголовок окна 
		WS_OVERLAPPEDWINDOW, 		// Стиль окна
		CW_USEDEFAULT,			// X-координаты 
		CW_USEDEFAULT,			// Y-координаты 
		CW_USEDEFAULT,			// Ширина окна
		CW_USEDEFAULT,			// Высота окна
		NULL,			// Дескриптор окна-родителя
		NULL,			// Дескриптор меню окна
		hInst,		// Дескриптор экземпляра приложения
		NULL);		// Дополнительная информация
	if (!hWnd)
	{
		// Окно не создано, выдаем предупреждение.
		MessageBox(NULL,
			"Create: error", AppTitle, MB_OK | MB_ICONSTOP);
		return FALSE;
	}

	// Отображаем окно.
	ShowWindow(hWnd, nCmdShow);

	// Обновляем содержимое клиентской области окна.
	UpdateWindow(hWnd);

	// Запускаем цикл обработки очереди сообщений.
	// Функция GetMessage получает сообщение из очереди, 
	// выдает false при выборке из очереди сообщения WM_QUIT
	while (GetMessage(&msg, NULL, 0, 0))
	{
		// Преобразование некоторых сообщений, 
		// полученных с помощью клавиатуры
		TranslateMessage(&msg);
		// Отправляем сообщение оконной процедуре
		DispatchMessage(&msg);
	}

	return msg.wParam;
}


// --- Функция окна
LRESULT CALLBACK WndProc(HWND hWnd, UINT msg, WPARAM wParam, LPARAM lParam)
{

	static STAR str;

	switch (msg)
	{

	
	case WM_PAINT:
	{
		PAINTSTRUCT ps;
		HDC hDC;

		hDC = BeginPaint(hWnd,&ps);
		random(hWnd,str.N, str.x, str.y, str.r, str.color);
		star(hDC, str);
		EndPaint(hWnd, &ps);
	}; break;


	
	case WM_DESTROY:
	{
		
		PostQuitMessage(0);
	}; break;

	
	default: return DefWindowProc(hWnd, msg, wParam, lParam);
	}
	return 0l;
}
