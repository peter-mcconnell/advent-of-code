#include <stdio.h>
#include <string.h>
#include <stddef.h>
#include <limits.h>
#include <ctype.h>

static int wherezit(const char* str, int idx, int b);
static inline char* reverse(char* str);

// all the stringy nonsense
static char* numbers[][2] = {
	{"one", "eno"},
	{"two", "owt"},
	{"three", "eerht"},
	{"four", "ruof"},
	{"five", "evif"},
	{"six", "xis"},
	{"seven", "neves"},
	{"eight", "thgie"},
	{"nine", "enin"},
};

char* reverse(char* str) {
	size_t len = strlen(str);
	for (size_t i = 0; i < len/2; i++) {
		size_t j = len-i-1;
		char tmp = str[i];
		str[i] = str[j];
		str[j] = tmp;
	}

	return str;
}

int wherezit(const char* str, int idx, int b) {
	size_t len = strlen(str);
	ptrdiff_t min0 = INT_MAX;
	int n[2] = { 0 };

	for (size_t i = 0; i < len; i++) {
		if (isdigit(str[i])) {
			min0 = i;
			n[0] = (str[i] - '0')*b;
			break;
		}
	}

	ptrdiff_t min1 = INT_MAX;
	for (int i = 0; i < 9; i++) {
		char* ptr = strstr(str, numbers[i][idx]);
		ptrdiff_t diff = ptr - str;
		if (ptr && diff < min1) {
			min1 = diff;
			n[1] = (i+1)*b;
		}
	}

	return (ptrdiff_t)min0 < min1 ? n[0] : n[1];
}

int main() {
	size_t result = 0;
	char buf[512];
	char* line;
	while (line = fgets(buf, sizeof(buf), stdin), line != NULL) {
		// get left number
		int left = wherezit(line, 0, 10);
		result += left;
		reverse(line);
		// get right number
		int right = wherezit(line, 1, 1);
		result += right;
		reverse(line);
		printf("%d + %d == %s", left, right, line);
	}

	printf("result: %ld\n", result);
	return 0;
}
